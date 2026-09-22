<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chatroom;
use App\ChatroomMessage;
use App\ChatroomPresence;
use App\AdditionalMenuSetting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class ChatroomController extends Controller
{
    /**
     * Categories allowed
     */
    protected $validCategories = ['all', 'general', 'student', 'lawyer', 'researcher'];

    /**
     * List chatrooms for a given category (or all for Chatroom Hub)
     */
    public function index(Request $request, $category = 'all')
    {
        if (!in_array($category, $this->validCategories)) {
            $category = 'all';
        }

        // Record presence for online counter
        $sessionId = $request->session()->getId();
        $userId = auth()->id();
        ChatroomPresence::touchPresence($category, $sessionId, $userId);

        $onlineCount = ChatroomPresence::getOnlineCount($category);

        $query = Chatroom::query();
        if ($category !== 'all') {
            $query->where('category', $category);
        }

        // Optional filter: search
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Optional filter: filter by tab (all, premium, trending)
        $tab = $request->input('tab', 'all');
        if ($tab === 'premium') {
            if (!auth()->check()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Guest users cannot access premium rooms. Please sign in or register.'
                    ], 403);
                }
                $redirectUrl = ($category === 'all') ? route('chatroom.index') : route('chatroom.category', $category);
                return redirect($redirectUrl)
                    ->with('error', 'Guest users cannot access premium rooms. Please sign in or register to view exclusive discussions.');
            }
            $query->where('is_premium', true);
        } elseif ($tab === 'trending') {
            $query->orderBy('replies_count', 'desc');
        }

        $chatrooms = $query->with('user')
            ->withCount('messages')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categoryLabels = Chatroom::categoryLabels();
        $categoryIcons = Chatroom::categoryIcons();
        $categoryColors = Chatroom::categoryColors();

        return view('chatroom.index', compact(
            'chatrooms', 'category', 'onlineCount', 'categoryLabels', 'categoryIcons', 'categoryColors', 'tab'
        ));
    }

    /**
     * Show a single chatroom discussion / thread
     */
    public function show(Request $request, $category, $slug)
    {
        $room = Chatroom::where('slug', $slug)->with(['user', 'messages.user'])->firstOrFail();

        // Gating: Guest users cannot access premium rooms
        if ($room->is_premium && !auth()->check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Guest users cannot access premium rooms. Please sign in or register.'
                ], 403);
            }
            return redirect()->route('chatroom.category', $room->category)
                ->with('error', 'Guest users cannot access premium rooms. Please sign in or register to view this discussion.');
        }

        // Increment views
        $room->increment('views_count');

        // Record presence
        $sessionId = $request->session()->getId();
        ChatroomPresence::touchPresence($room->category, $sessionId, auth()->id());
        $onlineCount = ChatroomPresence::getOnlineCount($room->category);

        $messages = $room->messages()
            ->whereNull('parent_id')
            ->with(['user', 'replies.user'])
            ->orderBy('created_at', 'asc')
            ->get();

        $categoryLabels = Chatroom::categoryLabels();

        return view('chatroom.show', compact('room', 'messages', 'onlineCount', 'categoryLabels'));
    }

    /**
     * Store a newly created chatroom discussion (from Dashboard or Chatroom page)
     */
    public function store(Request $request)
    {
        $isGuest = !auth()->check();

        if ($isGuest) {
            // Guest users are strictly restricted to the General Room only
            if ($request->input('category') !== 'general') {
                $errorMsg = 'Guest users can only start discussions under the General Room. Please sign in to create discussions in specialized rooms.';
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => $errorMsg], 403);
                }
                return back()->with('error', $errorMsg);
            }

            // Check if guest details are already remembered in session or cookie
            $savedGuestEmail   = session('guest_chat_email') ?: $request->cookie('guest_chat_email');
            $savedGuestName    = session('guest_chat_name') ?: $request->cookie('guest_chat_name');
            $savedGuestContact = session('guest_chat_contact') ?: $request->cookie('guest_chat_contact');

            $isFirstTime = empty($savedGuestEmail) && !$request->filled('guest_email');

            if ($isFirstTime) {
                // First-time guest: Name and Email are required; Contact is not compulsory
                $request->validate([
                    'title'         => 'required|string|max:255',
                    'category'      => 'required|string|in:general',
                    'description'   => 'required|string|min:10',
                    'guest_name'    => 'required|string|max:80',
                    'guest_email'   => 'required|email|max:150',
                    'guest_contact' => 'nullable|string|max:50',
                ], [
                    'guest_name.required'  => 'Please provide your name or pseudonym to start your first discussion.',
                    'guest_email.required' => 'Please provide your email address for initial discussion setup.',
                    'guest_email.email'    => 'Please provide a valid email address.',
                ]);

                $guestName    = trim($request->input('guest_name')) ?: 'Guest Member';
                $guestEmail   = trim($request->input('guest_email'));
                $guestContact = $request->filled('guest_contact') ? trim($request->input('guest_contact')) : null;
            } else {
                // Returning guest: Name, Email and Contact are NOT demanded
                $request->validate([
                    'title'         => 'required|string|max:255',
                    'category'      => 'required|string|in:general',
                    'description'   => 'required|string|min:10',
                    'guest_name'    => 'nullable|string|max:80',
                    'guest_email'   => 'nullable|email|max:150',
                    'guest_contact' => 'nullable|string|max:50',
                ]);

                $guestName    = trim($request->input('guest_name')) ?: ($savedGuestName ?: 'Guest Member');
                $guestEmail   = trim($request->input('guest_email')) ?: $savedGuestEmail;
                $guestContact = trim($request->input('guest_contact')) ?: $savedGuestContact;
            }

            // Persist to session and long-lived cookie (1 year) so details won't be requested again
            session([
                'guest_chat_name'    => $guestName,
                'guest_chat_email'   => $guestEmail,
                'guest_chat_contact' => $guestContact,
            ]);
            Cookie::queue('guest_chat_name', $guestName, 60 * 24 * 365);
            if ($guestEmail) {
                Cookie::queue('guest_chat_email', $guestEmail, 60 * 24 * 365);
            }
            if ($guestContact) {
                Cookie::queue('guest_chat_contact', $guestContact, 60 * 24 * 365);
            }

            $userId = null;
            $category = 'general';
            $isPremium = false;
        } else {
            $request->validate([
                'title'       => 'required|string|max:255',
                'category'    => 'required|string|in:general,student,lawyer,researcher',
                'description' => 'required|string|min:10',
            ]);

            $user = auth()->user();
            $category = $request->input('category');

            // Role-based authorization check:
            // Student can post in student & general
            // Lawyer can post in lawyer & general
            // Researcher can post in researcher & general
            // Admin can post in any
            if (!$user->isAdmin()) {
                $userRole = strtolower($user->user_type ?? '');
                if ($category !== 'general') {
                    if ($category === 'student' && $userRole !== 'student') {
                        return back()->with('error', 'Only verified Law Students can start rooms in the Student Chatroom.');
                    }
                    if ($category === 'lawyer' && $userRole !== 'lawyer') {
                        return back()->with('error', 'Only verified Legal Practitioners can start rooms in the Lawyer Chatroom.');
                    }
                    if ($category === 'researcher' && $userRole !== 'researcher') {
                        return back()->with('error', 'Only verified Researchers can start rooms in the Researcher Chatroom.');
                    }
                }
            }

            $userId = $user->id;
            $guestName = null;
            $guestEmail = null;
            $guestContact = null;
            $isPremium = false;
            if ($request->has('is_premium') && ($user->hasFullAccess() || $user->isAdmin())) {
                $isPremium = true;
            }
            $isPinned = false;
            if ($request->has('is_pinned') && $user->isAdmin()) {
                $isPinned = true;
            }
        }

        $slug = Chatroom::generateUniqueSlug($request->input('title'));

        $room = Chatroom::create([
            'user_id'          => $userId,
            'guest_name'       => $guestName,
            'guest_email'      => $guestEmail,
            'guest_contact'    => $guestContact,
            'category'         => $category,
            'title'            => $request->input('title'),
            'slug'             => $slug,
            'description'      => $request->input('description'),
            'is_premium'       => $isPremium,
            'is_pinned'        => $isPinned,
            'last_activity_at' => now(),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'redirect' => route('chatroom.show', [$room->category, $room->slug])
            ]);
        }

        return redirect()->route('chatroom.show', [$room->category, $room->slug])
            ->with('success', 'Chatroom discussion created successfully!');
    }

    /**
     * Post a reply / message into a chatroom thread
     */
    public function postMessage(Request $request, $id)
    {
        $room = Chatroom::findOrFail($id);

        $isAdmin = auth()->check() && auth()->user()->isAdmin();

        if ($room->is_locked && !$isAdmin) {
            return back()->with('error', 'This discussion thread has been locked by an administrator.');
        }

        // Gating: Guest users cannot participate in premium rooms
        if ($room->is_premium && !auth()->check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Guest users cannot participate in premium rooms. Please sign in or register.'
                ], 403);
            }
            return back()->with('error', 'Guest users cannot participate in premium rooms. Please sign in or register.');
        }

        $request->validate([
            'message'    => 'required|string|min:2',
            'guest_name' => 'nullable|string|max:80',
            'parent_id'  => 'nullable|integer|exists:chatroom_messages,id',
        ]);

        $userId = auth()->id();
        $guestName = null;

        if (!$userId) {
            $guestName = trim($request->input('guest_name')) ?: 'Guest Member';
        }

        $msg = ChatroomMessage::create([
            'chatroom_id' => $room->id,
            'user_id'     => $userId,
            'guest_name'  => $guestName,
            'message'     => function_exists('clean_law_text') ? clean_law_text($request->input('message')) : trim(strip_tags($request->input('message'))),
            'parent_id'   => $request->input('parent_id'),
        ]);

        $room->increment('replies_count');
        $room->update(['last_activity_at' => now()]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Reply posted successfully.',
                'author'  => $msg->author_name,
                'role'    => $msg->author_role,
                'created' => $msg->created_at->diffForHumans(),
            ]);
        }

        return back()->with('success', 'Reply posted successfully.');
    }

    /**
     * AJAX Heartbeat to maintain online presence & fetch live count
     */
    public function heartbeat(Request $request, $category)
    {
        if (!in_array($category, $this->validCategories)) {
            $category = 'all';
        }

        $sessionId = $request->session()->getId();
        ChatroomPresence::touchPresence($category, $sessionId, auth()->id());
        $count = ChatroomPresence::getOnlineCount($category);

        return response()->json([
            'category'    => $category,
            'onlineCount' => $count,
        ]);
    }
}
