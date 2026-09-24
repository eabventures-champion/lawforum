<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chatroom;
use App\ChatroomMessage;
use App\ChatroomPresence;
use App\ChatroomAccess;
use App\ChatroomJoinRequest;
use App\AdminNotification;
use App\AdditionalMenuSetting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;

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
        if (auth()->check() && !auth()->user()->hasFullAccess()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An active subscription is required to access the Community Chatrooms.',
                    'redirect' => url('/subscription')
                ], 403);
            }
            return redirect('/subscription')->with('error', 'An active subscription is required to access the Community Chatrooms.');
        }

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
        if (auth()->check() && !auth()->user()->hasFullAccess()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An active subscription is required to access the Community Chatrooms.',
                    'redirect' => url('/subscription')
                ], 403);
            }
            return redirect('/subscription')->with('error', 'An active subscription is required to access the Community Chatrooms.');
        }

        $room = Chatroom::where('slug', $slug)->with(['user', 'messages.user'])->firstOrFail();

        $sessionId = $request->session()->getId();
        $user = auth()->user();

        // Increment views
        $room->increment('views_count');

        // Record presence
        ChatroomPresence::touchPresence($room->category, $sessionId, auth()->id());
        $onlineCount = ChatroomPresence::getOnlineCount($room->category);

        $isCreator = $user && $room->user_id && ($room->user_id === $user->id);
        $isAdmin = $user && $user->isAdmin();
        $isUnlocked = $room->isUnlockedBy($user, $sessionId);
        $isExpired = $room->isExpired();

        $messages = collect();
        $pendingRequests = collect();

        // If unlocked, or if creator, or if admin: load conversation feed
        // If expired, the researcher (creator) and admin still have full access to view and manage content
        if ($isUnlocked || $isCreator || $isAdmin) {
            $messages = $room->messages()
                ->whereNull('parent_id')
                ->with(['user', 'replies.user'])
                ->orderBy('created_at', 'asc')
                ->get();

            if ($isCreator || $isAdmin) {
                $pendingRequests = $room->joinRequests()->where('status', 'pending')->get();
            }
        }

        $categoryLabels = Chatroom::categoryLabels();

        return view('chatroom.show', compact(
            'room', 'messages', 'onlineCount', 'categoryLabels',
            'isUnlocked', 'isCreator', 'isAdmin', 'isExpired', 'pendingRequests'
        ));
    }

    /**
     * Store a newly created chatroom discussion (from Dashboard or Chatroom page)
     */
    public function store(Request $request)
    {
        if (auth()->check() && !auth()->user()->hasFullAccess()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An active subscription is required to publish discussions.',
                    'redirect' => url('/subscription')
                ], 403);
            }
            return redirect('/subscription')->with('error', 'An active subscription is required to publish discussions.');
        }

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

            // Persist to session and long-lived cookie (1 year)
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
            $accessType = 'public';
            $securityCode = null;
            $creatorWhatsapp = null;
            $creatorEmail = null;
            $expiresAt = null;
            $isPinned = false;
        } else {
            $request->validate([
                'title'       => 'required|string|max:255',
                'category'    => 'required|string|in:general,student,lawyer,researcher',
                'description' => 'required|string|min:10',
            ]);

            $user = auth()->user();
            $category = $request->input('category');

            // Role-based authorization check:
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
            $accessType = 'public';
            $securityCode = null;
            $creatorWhatsapp = null;
            $creatorEmail = null;
            $expiresAt = null;

            // Check if user has permission to publish as Premium:
            // Full Access subscribers, Admins, Researchers, or Lawyers
            $userRole = strtolower($user->user_type ?? '');
            $canPublishPremium = $user->hasFullAccess() 
                || $user->isAdmin() 
                || in_array($userRole, ['researcher', 'lawyer']);

            if ($request->has('is_premium') && $canPublishPremium) {
                $isPremium = true;
                $accessType = $request->input('access_type', 'security_pass');

                if ($accessType === 'security_pass') {
                    $providedCode = trim($request->input('security_code', ''));
                    $securityCode = !empty($providedCode) ? strtoupper($providedCode) : ('SEC-' . strtoupper(Str::random(6)));
                    $creatorWhatsapp = trim($request->input('creator_whatsapp')) ?: ($user->phone ?? null);
                    $creatorEmail = trim($request->input('creator_email')) ?: $user->email;
                }

                // Premium forum rooms have a validity period of at most 1 month duration (30 days)
                $expiresAt = now()->addDays(30);
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
            'access_type'      => $accessType,
            'security_code'    => $securityCode,
            'creator_whatsapp' => $creatorWhatsapp,
            'creator_email'    => $creatorEmail,
            'expires_at'       => $expiresAt,
            'is_pinned'        => $isPinned,
            'last_activity_at' => now(),
        ]);

        // Auto-grant access to the creator
        if ($room->is_premium && $userId) {
            ChatroomAccess::create([
                'chatroom_id'   => $room->id,
                'user_id'       => $userId,
                'session_id'    => $request->session()->getId(),
                'access_method' => 'author',
                'unlocked_at'   => now(),
            ]);
            session(["chatroom_unlocked_{$room->id}" => true]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'redirect' => route('chatroom.show', [$room->category, $room->slug])
            ]);
        }

        return redirect()->route('chatroom.show', [$room->category, $room->slug])
            ->with('success', 'Discussion room published successfully!');
    }

    /**
     * Unlock a premium chatroom using a security pass code
     */
    public function unlockWithPass(Request $request, $id)
    {
        $room = Chatroom::findOrFail($id);

        $request->validate([
            'security_code' => 'required|string',
        ], [
            'security_code.required' => 'Please enter the security pass code.',
        ]);

        $enteredCode = strtoupper(trim($request->input('security_code')));
        $actualCode  = strtoupper(trim($room->security_code ?? ''));

        if (empty($actualCode) || $enteredCode !== $actualCode) {
            $msg = 'The security pass you entered is invalid. Please double-check the code or request access from the author.';
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return back()->with('error', $msg)->withInput();
        }

        // Passed security check! Record access
        $userId    = auth()->id();
        $sessionId = $request->session()->getId();

        ChatroomAccess::firstOrCreate([
            'chatroom_id' => $room->id,
            'user_id'     => $userId,
            'session_id'  => $sessionId,
        ], [
            'access_method' => 'security_pass',
            'unlocked_at'   => now(),
        ]);

        session(["chatroom_unlocked_{$room->id}" => true]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'  => true,
                'message'  => 'Security pass accepted! Welcome to the premium discussion.',
                'redirect' => route('chatroom.show', [$room->category, $room->slug])
            ]);
        }

        return redirect()->route('chatroom.show', [$room->category, $room->slug])
            ->with('success', 'Security pass verified! You have successfully unlocked this premium discussion.');
    }

    /**
     * In-app request to the researcher for the security pass
     */
    public function requestPass(Request $request, $id)
    {
        $room = Chatroom::with('user')->findOrFail($id);

        $request->validate([
            'requester_name'  => 'required|string|max:100',
            'requester_email' => 'required|email|max:150',
            'requester_phone' => 'nullable|string|max:50',
            'note'            => 'nullable|string|max:1000',
        ]);

        $joinRequest = ChatroomJoinRequest::create([
            'chatroom_id'     => $room->id,
            'user_id'         => auth()->id(),
            'requester_name'  => trim($request->input('requester_name')),
            'requester_email' => trim($request->input('requester_email')),
            'requester_phone' => $request->filled('requester_phone') ? trim($request->input('requester_phone')) : null,
            'note'            => $request->filled('note') ? trim($request->input('note')) : null,
            'status'          => 'pending',
        ]);

        // Attempt sending email alert to the creator
        $creatorEmail = $room->creator_email ?: ($room->user ? $room->user->email : null);
        if ($creatorEmail) {
            try {
                $creatorName  = $room->author_name;
                $roomTitle    = $room->title;
                $reqName      = $joinRequest->requester_name;
                $reqEmail     = $joinRequest->requester_email;
                $reqPhone     = $joinRequest->requester_phone;
                $reqNote      = $joinRequest->note;
                $securityCode = $room->security_code;

                Mail::send([], [], function ($message) use ($creatorEmail, $creatorName, $roomTitle, $reqName, $reqEmail, $reqPhone, $reqNote, $securityCode) {
                    $phoneHtml = $reqPhone ? "<p><strong>Phone / WhatsApp:</strong> {$reqPhone}</p>" : "";
                    $noteHtml  = $reqNote ? "<p><strong>Note:</strong> " . e($reqNote) . "</p>" : "";
                    $message->to($creatorEmail)
                        ->subject("Pass Request for Premium Discussion: {$roomTitle}")
                        ->html("
                            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 24px; border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff; color: #1e293b;'>
                                <div style='border-bottom: 2px solid #3b82f6; padding-bottom: 12px; margin-bottom: 20px;'>
                                    <h2 style='color: #1e3a8a; margin: 0; font-size: 20px;'>Security Pass Request</h2>
                                    <p style='color: #64748b; font-size: 13px; margin: 4px 0 0 0;'>Legals Forum Premium Community</p>
                                </div>
                                <p>Hello <strong>{$creatorName}</strong>,</p>
                                <p>A member has requested access to join your premium forum discussion <strong>\"" . e($roomTitle) . "\"</strong>.</p>
                                <div style='background: #f8fafc; border: 1px solid #e2e8f0; padding: 16px; border-radius: 8px; margin: 18px 0;'>
                                    <p style='margin: 0 0 8px 0;'><strong>Requester Name:</strong> {$reqName}</p>
                                    <p style='margin: 0 0 8px 0;'><strong>Email:</strong> <a href='mailto:{$reqEmail}' style='color: #2563eb;'>{$reqEmail}</a></p>
                                    {$phoneHtml}
                                    {$noteHtml}
                                </div>
                                <div style='background: #fffbeb; border: 1px solid #fef3c7; padding: 14px; border-radius: 8px; margin-bottom: 18px;'>
                                    <span style='font-size: 12px; color: #92400e; display: block; margin-bottom: 4px;'>Your Discussion Security Pass:</span>
                                    <strong style='font-size: 18px; color: #b45309; letter-spacing: 1.5px;'>{$securityCode}</strong>
                                </div>
                                <p>You can send this security code directly to them via email or WhatsApp.</p>
                                <hr style='border: none; border-top: 1px solid #e2e8f0; margin: 24px 0 16px 0;'>
                                <p style='font-size: 11px; color: #94a3b8; text-align: center; margin: 0;'>Legals Forum &copy; " . date('Y') . " • Ghana's Premier Legal Community</p>
                            </div>
                        ");
                });
            } catch (\Exception $e) {
                // Keep request intact if mail server is unconfigured
            }
        }

        // Store Admin Notification
        try {
            AdminNotification::create([
                'type' => 'chatroom_pass_request',
                'data' => [
                    'type'            => 'chatroom_pass_request',
                    'chatroom_id'     => $room->id,
                    'chatroom_title'  => $room->title,
                    'requester_name'  => $joinRequest->requester_name,
                    'requester_email' => $joinRequest->requester_email,
                    'name'            => $joinRequest->requester_name,
                    'email'           => $joinRequest->requester_email,
                    'subject'         => 'Security Pass Request: ' . $room->title,
                    'message'         => 'Requested security pass code to join the premium forum room "' . $room->title . '". Contact requester at ' . $joinRequest->requester_email,
                ],
            ]);
        } catch (\Exception $e) {}

        $successMsg = 'Your request for the security pass has been sent to the researcher! You can also message them directly on WhatsApp for immediate receipt.';

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $successMsg]);
        }

        return back()->with('success', $successMsg);
    }

    /**
     * Author/Admin approves a pass request and sends the code to requester
     */
    public function approveRequest(Request $request, $id, $requestId)
    {
        $room = Chatroom::findOrFail($id);
        $user = auth()->user();

        $isCreatorOrAdmin = $user && ($user->isAdmin() || ($room->user_id && $room->user_id === $user->id));
        if (!$isCreatorOrAdmin) {
            abort(403, 'Unauthorized access.');
        }

        $joinRequest = ChatroomJoinRequest::where('chatroom_id', $room->id)->findOrFail($requestId);
        $joinRequest->update(['status' => 'approved']);

        if ($joinRequest->requester_email) {
            try {
                $reqEmail     = $joinRequest->requester_email;
                $reqName      = $joinRequest->requester_name;
                $roomTitle    = $room->title;
                $securityCode = $room->security_code;
                $roomUrl      = route('chatroom.show', [$room->category, $room->slug]);

                Mail::send([], [], function ($message) use ($reqEmail, $reqName, $roomTitle, $securityCode, $roomUrl) {
                    $message->to($reqEmail)
                        ->subject("Your Access Code for Premium Discussion: {$roomTitle}")
                        ->html("
                            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 24px; border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff; color: #1e293b;'>
                                <div style='border-bottom: 2px solid #10b981; padding-bottom: 12px; margin-bottom: 20px;'>
                                    <h2 style='color: #065f46; margin: 0; font-size: 20px;'>Security Pass Approved!</h2>
                                    <p style='color: #64748b; font-size: 13px; margin: 4px 0 0 0;'>Legals Forum Premium Community</p>
                                </div>
                                <p>Hello <strong>{$reqName}</strong>,</p>
                                <p>Your request to join the premium forum room <strong>\"" . e($roomTitle) . "\"</strong> has been approved by the author.</p>
                                <div style='background: #fffbeb; border: 2px dashed #f59e0b; padding: 18px; border-radius: 10px; margin: 20px 0; text-align: center;'>
                                    <div style='font-size: 13px; font-weight: 600; color: #92400e; margin-bottom: 6px;'>Your Security Access Pass:</div>
                                    <div style='font-size: 26px; font-weight: 800; letter-spacing: 3px; color: #b45309;'>{$securityCode}</div>
                                </div>
                                <p style='text-align: center; margin: 24px 0;'>
                                    <a href='{$roomUrl}' style='display: inline-block; background: #2563eb; color: #ffffff; padding: 12px 26px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 14px;'>Join Discussion Thread</a>
                                </p>
                                <p style='font-size: 12px; color: #64748b;'>Enter this security pass when opening the discussion to unlock full participation.</p>
                                <hr style='border: none; border-top: 1px solid #e2e8f0; margin: 24px 0 16px 0;'>
                                <p style='font-size: 11px; color: #94a3b8; text-align: center; margin: 0;'>Legals Forum &copy; " . date('Y') . " • Ghana's Premier Legal Community</p>
                            </div>
                        ");
                });
            } catch (\Exception $e) {}
        }

        return back()->with('success', 'Pass request approved! The security pass has been emailed to ' . $joinRequest->requester_name . '.');
    }

    /**
     * Post a reply / message into a chatroom thread
     */
    public function postMessage(Request $request, $id)
    {
        if (auth()->check() && !auth()->user()->hasFullAccess()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An active subscription is required to participate in discussions.',
                    'redirect' => url('/subscription')
                ], 403);
            }
            return redirect('/subscription')->with('error', 'An active subscription is required to participate in discussions.');
        }

        $room = Chatroom::findOrFail($id);

        $user = auth()->user();
        $isCreatorOrAdmin = $user && ($user->isAdmin() || ($room->user_id && $room->user_id === $user->id));

        // Thread locked by administrator
        if ($room->is_locked && !$isCreatorOrAdmin) {
            return back()->with('error', 'This discussion thread has been locked by an administrator.');
        }

        // Validity period expiration check:
        // Premium Forum rooms lock after 1 month, while the researcher retains access to content
        if ($room->isExpired() && !$isCreatorOrAdmin) {
            $expiryNotice = 'This premium discussion reached its 1-month validity period on ' . $room->expires_at->format('M d, Y') . ' and is now locked for new replies.';
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $expiryNotice], 403);
            }
            return back()->with('error', $expiryNotice);
        }

        // Security Pass Gating check
        if ($room->is_premium && !$room->isUnlockedBy($user, $request->session()->getId())) {
            $lockMsg = 'You must enter the valid security pass to participate in this premium room.';
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $lockMsg], 403);
            }
            return back()->with('error', $lockMsg);
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
