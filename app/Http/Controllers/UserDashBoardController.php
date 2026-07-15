<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserBookmark;
use App\UserNote;
use App\Subscription;
use App\User;
use Carbon\Carbon;


// use App\Post1992Act;
// use Illuminate\Support\Facades\DB;

class UserDashBoardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->except(['save_note', 'get_document_notes']);
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
        $order_by_dates = UserBookmark::where(['user_id' => $user_id])->orderBy('created_at')->get();
        return view('user_dashboard.bookmarks', compact('order_by_dates'));
    }

    public function save_bookmark_article($act, $section, $section_id, $user_name, $user_id, $user_section, $act_group, $act_id){
        if (UserBookmark::where('user_section', '=', $user_section)->first())
            {
                return response()->json(
                            [
                            'success' => true,
                            'message' => 'Section bookmark already exists'
                            ]
                        );
            }  
        else{
            $user_bookmark = UserBookmark::Create(
                [
                    'user_section' => $user_section, 
                    'act_title' => $act, 
                    'act_section' => $section, 
                    'user_name' => $user_name, 
                    'user_id' => $user_id, 
                    'section_id' => $section_id, 
                    'act_id' => $act_id, 
                    'act_group' => $act_group]
                );  
            }
            $user_bookmark->save();           
    }

    //----------------------------------------------------------Subscription-------------------------------------------------------------
    //Display Packages
    public function subscription_index(){
        // if (auth()->user()->check_subscription) {
        //     return redirect()->back();
        // }
        $subscriptions = Subscription::all();
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
            $user->check_subscription = 1;
            $user->subscription_id = $subscription->id;
            $user->subscription_downloads = $subscription->no_downloads;
            $user->subscription_expiry = Carbon::today()->addDays($subscription->duration);
            $user->downloads_counts = 0;

        $user->saveOrFail();

        return 'successful';
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

        $request->validate([
            'document_type'  => 'required|string|max:50',
            'document_id'    => 'required|integer',
            'document_title' => 'required|string|max:500',
            'note_content'   => 'required|string|max:5000',
            'note_color'     => 'nullable|string|in:yellow,blue,green,pink,purple',
            'highlighted_text' => 'nullable|string|max:2000',
            'article_section'  => 'nullable|string|max:500',
            'page_url'       => 'required|string|max:1000',
        ]);

        $note = UserNote::create([
            'user_id'         => auth()->id(),
            'document_type'   => $request->document_type,
            'document_id'     => $request->document_id,
            'document_title'  => $request->document_title,
            'highlighted_text' => $request->highlighted_text,
            'note_content'    => $request->note_content,
            'note_color'      => $request->note_color ?? 'yellow',
            'article_section' => $request->article_section,
            'page_url'        => $request->page_url,
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
                'created_at'       => $note->created_at->diffForHumans(),
            ]
        ]);
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

        $notes = UserNote::where('user_id', auth()->id())
            ->where('document_type', $request->document_type)
            ->where('document_id', $request->document_id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($note) {
                return [
                    'id'               => $note->id,
                    'note_content'     => $note->note_content,
                    'highlighted_text' => $note->highlighted_text,
                    'note_color'       => $note->note_color,
                    'article_section'  => $note->article_section,
                    'created_at'       => $note->created_at->diffForHumans(),
                ];
            });

        return response()->json(['notes' => $notes]);
    }

    /**
     * Show all notes for the user on the dashboard.
     */
    public function show_user_notes($user_id)
    {
        $notes = UserNote::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user_dashboard.notes', compact('notes'));
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

}
