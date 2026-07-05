<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\NewsContent;
use App\Post1992Act;
use App\Pre1992LegislationAct;
use App\ConstitutionalAct;
use App\ExecutiveAct;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        
        $activeSubscriptions = User::where('subscription_expiry', '>=', Carbon::today())->count();
        
        $totalNews = NewsContent::count();
        
        $totalLaws = Post1992Act::count() + 
                     Pre1992LegislationAct::count() + 
                     ConstitutionalAct::count() + 
                     ExecutiveAct::count();

        // Get recent signups
        $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();
        
        // Get recent news
        $recentNews = NewsContent::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 
            'activeSubscriptions', 
            'totalNews', 
            'totalLaws', 
            'recentUsers',
            'recentNews'
        ));
    }
}
