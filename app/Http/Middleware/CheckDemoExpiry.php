<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DemoSetting;

class CheckDemoExpiry
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            if ($user->is_demo_mode && $user->demo_started_at) {
                // Check if main demo period just expired but extension not yet started
                if (!$user->isDemoActive() && !$user->demo_extended) {
                    // Auto-activate 15-day extension
                    $user->update(['demo_extended' => true]);
                    $extensionDays = (int) DemoSetting::get('demo_extension_days', 15);
                    session()->flash('demo_extension_notice', "Your demo period has ended. You have been granted a {$extensionDays}-day extension. Please consider subscribing.");
                }
                
                // Check if in extension period — show warning
                if ($user->isDemoExtensionActive()) {
                    $remaining = $user->demoRemainingDays();
                    session()->flash('demo_expiry_warning', "Your demo extension expires in {$remaining} day(s). Subscribe now to maintain full access.");
                }
                
                // Check if fully expired
                if ($user->isDemoExpired()) {
                    $user->expireDemoToGuest();
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return redirect('/get-started')->with('demo_expired', 'Your demo period has expired. Please subscribe to continue accessing full content.');
                }
            }
        }
        
        return $next($request);
    }
}
