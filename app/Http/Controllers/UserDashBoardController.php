<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserBookmark;
use App\Subscription;
use App\User;
use Carbon\Carbon;


// use App\Post1992Act;
// use Illuminate\Support\Facades\DB;

class UserDashBoardController extends Controller
{
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

}
