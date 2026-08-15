<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function choosePlan()
    {
        $user = auth()->user();
        
        // If user already has demo or is verified, redirect
        if ($user->is_demo_mode && $user->demo_started_at) {
            return redirect('/email/verify');
        }
        
        return view('auth.choose-plan', compact('user'));
    }

    public function activateDemo(Request $request)
    {
        $user = auth()->user();
        
        // Check if user has already used demo
        if ($user->demo_used) {
            return redirect('/')->with('error', 'You have already used your demo period.');
        }
        
        $user->startDemo();
        
        session()->flash('demo_activated', true);
        return redirect('/email/verify');
    }
}
