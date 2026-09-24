<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserBookmark;
use App\UserNote;
use App\Subscription;
use App\User;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Str;

use App\GhanaArticle;
use App\GhanaAct;
use App\Post1992Article;
use App\ConstitutionalArticle;
use App\ExecutiveArticle;
use App\RegulationArticle;
use App\AmendedArticle;
use App\AmendRegulationArticle;
use App\Pre1992LegislationArticle;
use App\Pre1992LegislationAct;
use App\Post1992Act;
use App\GhLawJudgment;


// use App\Post1992Act;
// use Illuminate\Support\Facades\DB;

class UserDashBoardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->except([
            'save_note',
            'get_document_notes',
            'toggle_bookmark',
            'check_bookmarks',
            'get_bookmark_content',
            'get_note_content'
        ]);
    }
    //----------------------------------------------------------Dashboard-------------------------------------------------------------
    public function dashboard(){
        return view('user_dashboard.dashboard');
    }

    //----------------------------------------------------------Profile---------------------------------------------------------------
    // public function show_user_profile ($user_id){
    //     $users = User::where(['id' => $user_id])->get();

    //     return view('user_dashboard.profile', compact('users'));
    // }

    //----------------------------------------------------------Bookmarks-------------------------------------------------------------
    public function show_user_bookmarks($user_id){
        $authUser = auth()->user();
        if (!$authUser->hasFullAccess()) {
            return redirect('/subscription')->with('error', 'Your demo period has expired. Please subscribe to regain access to your bookmarks and full platform features.');
        }

        $teamUserIds = $authUser->getTeamUserIds();
        $isTeam = count($teamUserIds) > 1;

        $bookmarks = UserBookmark::whereIn('user_id', $teamUserIds)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        // De-duplicate team bookmarks so the exact same section and act is never repeated
        if ($isTeam) {
            $bookmarks = $bookmarks->unique(function ($item) {
                return ($item->section_id ?: '0') . '___' . trim(strtolower($item->act_title)) . '___' . trim(strtolower($item->act_section));
            })->values();
        }

        $order_by_dates = $bookmarks;
        return view('user_dashboard.bookmarks', compact('bookmarks', 'order_by_dates', 'isTeam'));
    }

    /**
     * Fetch Bookmarked Section Content for Reader Modal.
     */
    public function get_bookmark_content($id)
    {
        $bookmark = UserBookmark::find($id);

        if (!$bookmark) {
            return response()->json([
                'success' => false,
                'message' => 'Bookmark not found.'
            ], 404);
        }

        $contentHtml = '';
        $docTitle = $bookmark->act_title;
        $sectionTitle = $bookmark->act_section;
        $docType = $bookmark->document_type;
        $actGroup = $bookmark->act_group ?: 'General';
        $sectionId = $bookmark->section_id;

        // Auto-detect docType if empty
        if (empty($docType)) {
            if (stripos($actGroup, 'Constitution') !== false) {
                $docType = 'constitution';
            } elseif (stripos($actGroup, 'Case') !== false || stripos($actGroup, 'Court') !== false) {
                $docType = 'case_law';
            } elseif (in_array($actGroup, ['First Republic', 'Second Republic', 'Third Republic', 'NLC Decree', 'NRC Decree', 'SMC Decree', 'AFRC Decree']) || stripos($actGroup, 'Republic') !== false || stripos($actGroup, 'Decree') !== false) {
                $docType = 'pre_1992';
            } else {
                $docType = 'legislation';
            }
        }

        // Fetch content based on document type
        try {
            if ($docType === 'constitution') {
                if ($sectionId == 0 || stripos($sectionTitle, 'Preamble') !== false) {
                    $ghanaAct = GhanaAct::find($bookmark->act_id ?: 1);
                    $contentHtml = $ghanaAct ? $ghanaAct->preamble : '';
                } else {
                    $ghanaArticle = GhanaArticle::find($sectionId);
                    if ($ghanaArticle) {
                        $contentHtml = $ghanaArticle->articles;
                        if (empty($sectionTitle)) $sectionTitle = $ghanaArticle->section;
                    }
                }
            } elseif ($docType === 'pre_1992') {
                $preArticle = Pre1992LegislationArticle::find($sectionId);
                if ($preArticle) {
                    $contentHtml = $preArticle->content;
                    if (empty($sectionTitle)) $sectionTitle = $preArticle->section;
                    if (empty($docTitle)) $docTitle = $preArticle->pre_1992_act;
                }
            } elseif ($docType === 'case_law') {
                $case = GhLawJudgment::find($sectionId ?: $bookmark->act_id);
                if ($case) {
                    $contentHtml = $case->judgement ?: ($case->content ?: $case->case_title_1);
                    if (empty($sectionTitle)) $sectionTitle = $case->case_title;
                }
            } else {
                // Post-1992 Legislation
                $article = Post1992Article::find($sectionId);
                if (!$article) $article = ConstitutionalArticle::find($sectionId);
                if (!$article) $article = ExecutiveArticle::find($sectionId);
                if (!$article) $article = RegulationArticle::find($sectionId);
                if (!$article) $article = AmendedArticle::find($sectionId);
                if (!$article) $article = AmendRegulationArticle::find($sectionId);

                if ($article) {
                    $contentHtml = $article->content;
                    if (empty($sectionTitle)) $sectionTitle = $article->section;
                }
            }
        } catch (\Exception $e) {
            $contentHtml = '<p style="color: #ef4444;">Unable to load content: ' . $e->getMessage() . '</p>';
        }

        if (empty($contentHtml)) {
            $contentHtml = '<p style="color: #94a3b8; font-style: italic;">No preview content available for this bookmarked section.</p>';
        }

        // Resolve valid canonical reader URL
        $resolvedPageUrl = $bookmark->page_url;
        if ($docType === 'constitution') {
            $resolvedPageUrl = "/constitution/Republic/Ghana/" . ($bookmark->act_id ?: 1) . "#article-" . $sectionId;
        } elseif ($docType === 'case_law') {
            $resolvedPageUrl = "/all_court_cases/Supreme-Court/" . ($bookmark->act_id ?: $sectionId);
        } elseif ($docType === 'pre_1992') {
            $act = null;
            if ($bookmark->act_id && $bookmark->act_id > 0) {
                $act = Pre1992LegislationAct::find($bookmark->act_id);
            }
            if (!$act) {
                $act = Pre1992LegislationAct::where('title', $docTitle)->first();
            }
            if ($act) {
                $group = !empty($act->pre_1992_group) ? $act->pre_1992_group : 'Second Republic';
                $resolvedPageUrl = "/existing-laws/" . rawurlencode($group) . "/" . rawurlencode($act->title) . "/" . $act->id . "#section-" . $sectionId;
            } else {
                $resolvedPageUrl = "/existing-laws";
            }
        } else {
            // Post-1992
            if ($bookmark->act_group === 'Judiciary') {
                $resolvedPageUrl = "/new-laws/constitutional-acts-table-of-content/Judiciary/" . rawurlencode($docTitle) . "/" . ($bookmark->act_id ?: 1) . "#section-" . $sectionId;
            } elseif ($bookmark->act_group === 'Legislative Instruments') {
                $resolvedPageUrl = "/new-laws/regulation_acts_table_of_content/Legislative%20Instruments/" . rawurlencode($docTitle) . "/" . ($bookmark->act_id ?: 1) . "#section-" . $sectionId;
            } else {
                $act = null;
                if ($bookmark->act_id && $bookmark->act_id > 0) {
                    $act = Post1992Act::find($bookmark->act_id);
                }
                if (!$act) {
                    $act = Post1992Act::where('title', $docTitle)->first();
                }
                $group = ($act && !empty($act->post_group)) ? $act->post_group : (!empty($bookmark->act_group) && $bookmark->act_group !== 'General' ? $bookmark->act_group : 'Acts of Parliament');
                $actId = $act ? $act->id : ($bookmark->act_id ?: 1);
                $resolvedPageUrl = "/new-laws/table-of-content/" . rawurlencode($group) . "/" . rawurlencode($docTitle) . "/" . $actId . "#section-" . $sectionId;
            }
        }

        return response()->json([
            'success'        => true,
            'id'             => $bookmark->id,
            'section_id'     => $sectionId,
            'act_id'         => $bookmark->act_id,
            'document_title' => $docTitle,
            'section_title'  => $sectionTitle,
            'act_group'      => $actGroup,
            'document_type'  => $docType,
            'created_at'     => date('F j, Y', strtotime($bookmark->created_at)),
            'content_html'   => $contentHtml,
            'page_url'       => $resolvedPageUrl,
            'can_delete'     => ($bookmark->user_id === auth()->id() || auth()->user()->isTeamOwner()),
        ]);
    }

    /**
     * AJAX Toggle Bookmark (Add / Remove).
     */
    public function toggle_bookmark(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'guest'   => true,
                'message' => 'Please sign in or create a free account to bookmark sections.'
            ], 401);
        }

        if (!auth()->user()->hasFullAccess()) {
            return response()->json([
                'success' => false,
                'guest'   => true,
                'expired' => true,
                'message' => 'Your demo period has expired. Please subscribe to bookmark sections and access full platform features.'
            ], 403);
        }

        $request->validate([
            'act_title'     => 'required|string|max:500',
            'act_section'   => 'required|string|max:500',
            'section_id'    => 'nullable',
            'act_id'        => 'nullable',
            'act_group'     => 'nullable|string|max:255',
            'document_type' => 'nullable|string|max:100',
            'page_url'      => 'nullable|string|max:2000',
        ]);

        $userId = auth()->id();
        $sectionId = $request->input('section_id', 0);
        $actId = $request->input('act_id', 0);
        $docType = $request->input('document_type', 'legislation');
        $actGroup = $request->input('act_group', 'General');
        $actTitle = $request->input('act_title');
        $actSection = $request->input('act_section');
        $pageUrl = $request->input('page_url');

        $authUser = auth()->user();
        $teamUserIds = $authUser->getTeamUserIds();
        $isTeam = count($teamUserIds) > 1;

        // Form unique key for user section
        $userSectionKey = $userId . '_' . $docType . '_' . $actId . '_' . $sectionId;

        // Check if bookmark exists for this user or any teammate in team workspace
        $existing = UserBookmark::whereIn('user_id', $teamUserIds)
            ->where(function ($query) use ($userSectionKey, $sectionId, $actTitle, $actSection) {
                $query->where('user_section', $userSectionKey)
                    ->orWhere(function ($q2) use ($sectionId, $actTitle, $actSection) {
                        if ($sectionId) {
                            $q2->where('section_id', $sectionId)->where('act_title', $actTitle);
                        } else {
                            $q2->where('act_title', $actTitle)->where('act_section', $actSection);
                        }
                    });
            })
            ->first();

        if ($existing) {
            // If the user created it, or if the team owner removes it, delete the bookmark
            if ($existing->user_id === $userId || $authUser->isTeamOwner()) {
                $existing->delete();
                $totalBookmarks = UserBookmark::whereIn('user_id', $teamUserIds)->count();

                return response()->json([
                    'success'    => true,
                    'bookmarked' => false,
                    'count'      => $totalBookmarks,
                    'message'    => 'Bookmark removed.'
                ]);
            } else {
                // If a collaborator clicks on a section already bookmarked by the team owner or another teammate,
                // do NOT duplicate it. Instead inform them that it is already saved in the team workspace.
                $creator = $existing->user ? trim($existing->user->name . ' ' . $existing->user->lname) : ($existing->user_name ?: 'a team member');
                $totalBookmarks = UserBookmark::whereIn('user_id', $teamUserIds)->count();

                return response()->json([
                    'success'            => true,
                    'bookmarked'         => true,
                    'already_bookmarked' => true,
                    'count'              => $totalBookmarks,
                    'message'            => "This section is already bookmarked for your team workspace by {$creator}."
                ]);
            }
        }

        $bookmark = UserBookmark::create([
            'user_id'       => $userId,
            'user_name'     => auth()->user()->name ?? 'User',
            'act_title'     => $actTitle,
            'act_section'   => $actSection,
            'section_id'    => $sectionId,
            'act_id'        => $actId,
            'act_group'     => $actGroup,
            'user_section'  => $userSectionKey,
            'document_type' => $docType,
            'page_url'      => $pageUrl,
        ]);

        $totalBookmarks = UserBookmark::whereIn('user_id', $teamUserIds)->count();

        return response()->json([
            'success'    => true,
            'bookmarked' => true,
            'count'      => $totalBookmarks,
            'bookmark'   => $bookmark,
            'message'    => $isTeam ? 'Section bookmarked for your team workspace!' : 'Section bookmarked successfully!'
        ]);
    }

    /**
     * AJAX Check which sections on the current document are bookmarked.
     */
    public function check_bookmarks(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['bookmarked_section_ids' => [], 'user_section_keys' => []]);
        }

        $teamUserIds = auth()->user()->getTeamUserIds();
        $actTitle = $request->input('act_title');
        $actId = $request->input('act_id');
        $docType = $request->input('document_type');

        $query = UserBookmark::whereIn('user_id', $teamUserIds);
        if ($actTitle) {
            $query->where('act_title', $actTitle);
        }
        if ($actId) {
            $query->where('act_id', $actId);
        }
        if ($docType) {
            $query->where('document_type', $docType);
        }

        $bookmarks = $query->get(['id', 'user_id', 'section_id', 'act_section', 'user_section']);

        return response()->json([
            'bookmarks'              => $bookmarks,
            'bookmarked_section_ids' => $bookmarks->pluck('section_id')->filter()->values(),
            'user_section_keys'      => $bookmarks->pluck('user_section')->filter()->values(),
        ]);
    }

    /**
     * Delete Bookmark.
     */
    public function destroy_bookmark($id)
    {
        $authUser = auth()->user();
        $teamUserIds = $authUser->getTeamUserIds();

        // Allow owner to delete any bookmark in team, or user to delete their own bookmark
        $bookmark = UserBookmark::where('id', $id)
            ->whereIn('user_id', $teamUserIds)
            ->firstOrFail();

        // If not the owner and not own bookmark, prevent unauthorized deletion
        if ($bookmark->user_id !== $authUser->id && !$authUser->isTeamOwner()) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only the account holder or bookmark creator can remove this bookmark.'
                ], 403);
            }
            return redirect()->back()->with('error', 'Only the account holder or bookmark creator can remove this bookmark.');
        }

        $bookmark->delete();

        if (request()->ajax() || request()->wantsJson()) {
            $newCount = UserBookmark::whereIn('user_id', $teamUserIds)->count();
            return response()->json([
                'success' => true,
                'count'   => $newCount,
                'message' => 'Bookmark deleted successfully!'
            ]);
        }

        return redirect()->back()->with('success', 'Bookmark deleted successfully!');
    }

    //----------------------------------------------------------Subscription-------------------------------------------------------------
    //Display Packages
    public function subscription_index(){
        // if (auth()->user()->check_subscription) {
        //     return redirect()->back();
        // }
        $subscriptions = Subscription::where('is_active', true)->orderBy('price', 'asc')->get();
        // If no active plans found, fallback to all plans so page doesn't appear empty
        if ($subscriptions->isEmpty()) {
            $subscriptions = Subscription::orderBy('price', 'asc')->get();
        }
        return view('user_dashboard.subscription', compact('subscriptions'));
    }
    
    //Display Users Selected Package
    public function show_user_subscriptions(Subscription $subscription){
        // $user = User::findOrFail(auth()->user()->id);
        $type = $subscription->type;
        dd($type);
    }

    //Processing
    public function process(Subscription $subscription){
        $user = User::findOrFail(auth()->user()->id);

        // Collaborator guard: If user is a collaborator under another account holder
        if ($user->isTeamMember()) {
            $membership = $user->teamMembership;
            $owner = $user->getTeamOwner();

            if (!$membership || !$membership->can_manage_billing) {
                $ownerName = $owner ? trim($owner->name . ' ' . $owner->lname) : 'the primary Account Holder';
                return response()->json([
                    'status' => 'permission_denied',
                    'message' => "You are collaborating under {$ownerName}'s team workspace. Permission from the Account Holder is required to modify or purchase subscriptions."
                ], 403);
            }

            // If collaborator has permission, update the primary account holder's subscription!
            $targetUser = $owner ?: $user;
        } else {
            $targetUser = $user;
        }

        // Guard: Prevent re-processing if user is already actively subscribed to this exact plan
        if ($targetUser->check_subscription && (int)$targetUser->subscription_id === (int)$subscription->id && $targetUser->subscription_expiry && Carbon::parse($targetUser->subscription_expiry)->isFuture()) {
            return response()->json([
                'status' => 'already_active',
                'message' => 'The workspace already has an active subscription for this plan.'
            ], 400);
        }

        $targetUser->check_subscription = 1;
        $targetUser->subscription_id = $subscription->id;
        $targetUser->subscription_downloads = $subscription->no_downloads;

        // Carry over any remaining days from existing active subscription or trial
        $existingDaysRemaining = 0;
        if ($targetUser->subscription_expiry && Carbon::parse($targetUser->subscription_expiry)->isFuture()) {
            $existingDaysRemaining = max(0, (int) ceil(now()->diffInDays(Carbon::parse($targetUser->subscription_expiry), false)));
        }

        $trialDaysRemaining = 0;
        if (method_exists($targetUser, 'demoRemainingDays')) {
            $trialDaysRemaining = max(0, (int)$targetUser->demoRemainingDays());
        }

        $carryOverDays = max($existingDaysRemaining, $trialDaysRemaining);
        $totalDays = (int)$subscription->duration + $carryOverDays;
        $targetUser->subscription_expiry = Carbon::today()->addDays($totalDays);
        $targetUser->downloads_counts = 0;

        // Turn off demo mode so the user transitions into a full active subscriber
        $targetUser->is_demo_mode = 0;

        $targetUser->saveOrFail();

        // If this was an authorized collaborator who completed the purchase, clear their pending request
        if ($user->isTeamMember() && isset($membership) && $membership) {
            $membership->update([
                'billing_request_status' => 'approved',
                'billing_request_plan_id' => null,
                'billing_request_note' => null,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Subscription activated successfully.'
        ]);
    }

    //----------------------------------------------------------Notes-------------------------------------------------------------
    /**
     * Save a new note (AJAX POST).
     * Guests are rejected with a 401 JSON response.
     */
    public function save_note(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to save notes.',
                'require_login' => true
            ], 401);
        }

        if (!auth()->user()->hasFullAccess()) {
            return response()->json([
                'success' => false,
                'expired' => true,
                'message' => 'Your demo period has expired. Please subscribe to create notes and access full platform features.'
            ], 403);
        }

        try {
            $request->validate([
                'document_type'  => 'required|string|max:50',
                'document_id'    => 'nullable',
                'document_title' => 'required|string|max:500',
                'note_content'   => 'required|string|max:5000',
                'note_color'     => 'nullable|string|in:yellow,blue,green,pink,purple',
                'highlighted_text' => 'nullable|string|max:5000',
                'article_section'  => 'nullable|string|max:500',
                'page_url'       => 'nullable|string|max:2000',
            ]);

            $note = UserNote::create([
                'user_id'         => auth()->id(),
                'document_type'   => $request->document_type,
                'document_id'     => (int)($request->document_id ?? 0),
                'document_title'  => $request->document_title,
                'highlighted_text' => $request->highlighted_text,
                'note_content'    => $request->note_content,
                'note_color'      => $request->note_color ?? 'yellow',
                'article_section' => $request->article_section,
                'page_url'        => $request->page_url ?? url()->previous(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Note saved successfully!',
                'note'    => [
                    'id'               => $note->id,
                    'note_content'     => $note->note_content,
                    'highlighted_text' => $note->highlighted_text,
                    'note_color'       => $note->note_color,
                    'article_section'  => $note->article_section,
                    'created_at'       => $note->created_at ? $note->created_at->diffForHumans() : 'Just now',
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Please fill in all required fields.'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save note: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get notes for the current document (AJAX GET).
     * Returns empty array for guests.
     */
    public function get_document_notes(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['notes' => []]);
        }

        $teamUserIds = auth()->user()->getTeamUserIds();

        $notes = UserNote::whereIn('user_id', $teamUserIds)
            ->where('document_type', $request->document_type)
            ->where('document_id', $request->document_id)
            ->with(['user', 'comments.user'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($note) {
                $authorName = $note->user ? trim($note->user->name . ' ' . $note->user->lname) : 'Researcher';
                $isMe = $note->user_id === auth()->id();
                return [
                    'id'               => $note->id,
                    'note_content'     => $note->note_content,
                    'highlighted_text' => $note->highlighted_text,
                    'note_color'       => $note->note_color,
                    'article_section'  => $note->article_section,
                    'author_name'      => $isMe ? 'You' : $authorName,
                    'is_me'            => $isMe,
                    'comments_count'   => $note->comments->count(),
                    'created_at'       => $note->created_at->diffForHumans(),
                ];
            });

        return response()->json(['notes' => $notes]);
    }

    /**
     * Show all notes for the user on the dashboard (with team collaboration).
     */
    public function show_user_notes($user_id)
    {
        $authUser = auth()->user();
        if (!$authUser->hasFullAccess()) {
            return redirect('/subscription')->with('error', 'Your demo period has expired. Please subscribe to regain access to your notes and full platform features.');
        }

        $teamUserIds = $authUser->getTeamUserIds();
        $isTeam = count($teamUserIds) > 1;

        $notes = UserNote::whereIn('user_id', $teamUserIds)
            ->with(['user', 'comments.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user_dashboard.notes', compact('notes', 'isTeam'));
    }

    /**
     * Add a collaborative discussion comment on a shared note.
     */
    public function add_note_comment(Request $request, $id)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
        }

        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $teamUserIds = auth()->user()->getTeamUserIds();
        $note = UserNote::whereIn('user_id', $teamUserIds)->findOrFail($id);

        $comment = \App\UserNoteComment::create([
            'user_note_id' => $note->id,
            'user_id' => auth()->id(),
            'comment' => trim($request->comment),
        ]);

        $comment->load('user');
        $authorName = $comment->user ? trim($comment->user->name . ' ' . $comment->user->lname) : 'Researcher';

        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'comment' => $comment->comment,
                'author_name' => $authorName,
                'created_at' => $comment->created_at->diffForHumans(),
            ],
        ]);
    }

    /**
     * Fetch a note's full details and section context for the modal viewer.
     */
    public function get_note_content($id)
    {
        $note = UserNote::find($id);

        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'Note not found.'
            ], 404);
        }

        // Fetch surrounding legal section content if section_id exists
        $sectionHtml = '';
        if ($note->section_id) {
            try {
                if ($note->document_type === 'constitution') {
                    $article = GhanaArticle::find($note->section_id);
                    if ($article) $sectionHtml = $article->articles;
                } elseif ($note->document_type === 'pre_1992') {
                    $article = Pre1992LegislationArticle::find($note->section_id);
                    if ($article) $sectionHtml = $article->content;
                } elseif (in_array($note->document_type, ['case_law', 'judgment', 'judgement'])) {
                    $case = GhLawJudgment::find($note->section_id);
                    if ($case) $sectionHtml = $case->judgement ?: $case->content;
                } else {
                    $article = Post1992Article::find($note->section_id);
                    if (!$article) $article = ConstitutionalArticle::find($note->section_id);
                    if (!$article) $article = ExecutiveArticle::find($note->section_id);
                    if (!$article) $article = RegulationArticle::find($note->section_id);
                    if (!$article) $article = AmendedArticle::find($note->section_id);
                    if ($article) $sectionHtml = $article->content;
                }
            } catch (\Exception $e) {}
        }

        $note->load(['user', 'comments.user']);
        $authorName = $note->user ? trim($note->user->name . ' ' . $note->user->lname) : 'Researcher';
        $isMe = ($note->user_id === auth()->id());
        $commentsData = $note->comments->map(function ($c) {
            return [
                'id' => $c->id,
                'author_name' => $c->user ? trim($c->user->name . ' ' . $c->user->lname) : 'Researcher',
                'is_me' => ($c->user_id === auth()->id()),
                'comment' => $c->comment,
                'created_at' => $c->created_at->diffForHumans(),
            ];
        });

        return response()->json([
            'success'          => true,
            'id'               => $note->id,
            'document_title'   => html_entity_decode($note->document_title ?? '', ENT_QUOTES, 'UTF-8'),
            'article_section'  => html_entity_decode($note->article_section ?? '', ENT_QUOTES, 'UTF-8'),
            'highlighted_text' => html_entity_decode($note->highlighted_text ?? '', ENT_QUOTES, 'UTF-8'),
            'note_content'     => $note->note_content,
            'note_color'       => $note->note_color ?? 'yellow',
            'document_type'    => $note->document_type ?? 'document',
            'page_url'         => $note->page_url,
            'created_at'       => $note->created_at ? $note->created_at->format('F j, Y \a\t g:i A') : '',
            'author_name'      => $authorName,
            'is_me'            => $isMe,
            'comments'         => $commentsData,
            'section_html'     => $sectionHtml,
            'pdf_url'          => route('notes.download.pdf', $note->id),
            'word_url'         => route('notes.download.word', $note->id)
        ]);
    }

    /**
     * Update an existing note (AJAX PATCH).
     */
    public function update_note(Request $request, $id)
    {
        $note = UserNote::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $request->validate([
            'note_content' => 'required|string|max:5000',
            'note_color'   => 'nullable|string|in:yellow,blue,green,pink,purple',
        ]);

        $note->update([
            'note_content' => $request->note_content,
            'note_color'   => $request->note_color ?? $note->note_color,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Note updated successfully!',
        ]);
    }

    /**
     * Delete a note (AJAX DELETE).
     */
    public function delete_note($id)
    {
        $note = UserNote::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $note->delete();

        return response()->json([
            'success' => true,
            'message' => 'Note deleted successfully!',
        ]);
    }

    /**
     * Download a single note as PDF.
     */
    public function download_note_pdf($id)
    {
        if (!auth()->user()->hasFullAccess()) {
            return redirect('/subscription')->with('error', 'Your demo period has expired. Please subscribe to download notes and access full platform features.');
        }

        $note = UserNote::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $notes = collect([$note]);
        $user = auth()->user();
        $title = 'Note - ' . strip_tags($note->document_title);

        $pdf = PDF::loadView('user_dashboard.notes_pdf', compact('notes', 'title', 'user'));
        $filename = 'Note_' . Str::slug(Str::limit($note->document_title, 30, ''), '_') . '_' . date('Ymd') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Download a single note as Word document.
     */
    public function download_note_word($id)
    {
        if (!auth()->user()->hasFullAccess()) {
            return redirect('/subscription')->with('error', 'Your demo period has expired. Please subscribe to download notes and access full platform features.');
        }

        $note = UserNote::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $notes = collect([$note]);
        $user = auth()->user();
        $title = 'Note - ' . strip_tags($note->document_title);

        $filename = 'Note_' . Str::slug(Str::limit($note->document_title, 30, ''), '_') . '_' . date('Ymd') . '.doc';

        return response()->view('user_dashboard.notes_word', compact('notes', 'title', 'user'))
            ->header('Content-Type', 'application/msword; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Cache-Control', 'max-age=0');
    }

    /**
     * Download all notes for the authenticated user as PDF.
     */
    public function download_all_notes_pdf()
    {
        if (!auth()->user()->hasFullAccess()) {
            return redirect('/subscription')->with('error', 'Your demo period has expired. Please subscribe to download notes and access full platform features.');
        }

        $notes = UserNote::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        if ($notes->isEmpty()) {
            return redirect()->back()->with('error', 'No notes found to download.');
        }

        $user = auth()->user();
        $title = 'All Study Notes - Legals Forum';

        $pdf = PDF::loadView('user_dashboard.notes_pdf', compact('notes', 'title', 'user'));
        $filename = 'All_Study_Notes_' . date('Ymd_His') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Download all notes for the authenticated user as Word document.
     */
    public function download_all_notes_word()
    {
        if (!auth()->user()->hasFullAccess()) {
            return redirect('/subscription')->with('error', 'Your demo period has expired. Please subscribe to download notes and access full platform features.');
        }

        $notes = UserNote::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        if ($notes->isEmpty()) {
            return redirect()->back()->with('error', 'No notes found to download.');
        }

        $user = auth()->user();
        $title = 'All Study Notes - Legals Forum';
        $filename = 'All_Study_Notes_' . date('Ymd_His') . '.doc';

        return response()->view('user_dashboard.notes_word', compact('notes', 'title', 'user'))
            ->header('Content-Type', 'application/msword; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Cache-Control', 'max-age=0');
    }

}
