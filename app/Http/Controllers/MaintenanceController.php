<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MaintenanceSetting;

class MaintenanceController extends Controller
{
    /**
     * Show the maintenance page.
     */
    public function show()
    {
        // If maintenance mode is not enabled, redirect to home
        if (!maintenance_setting('maintenance_enabled', false)) {
            return redirect('/');
        }

        $title = maintenance_setting('maintenance_title', "We're Upgrading Your Experience");
        $subtitle = maintenance_setting('maintenance_subtitle', 'Our team is working behind the scenes to bring you a better platform.');
        $dialogueMessages = maintenance_setting('maintenance_dialogue_messages', []);

        return view('maintenance', compact('title', 'subtitle', 'dialogueMessages'));
    }

    /**
     * Verify the passcode and grant bypass access.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'passcode' => 'required|string',
        ]);

        $storedPasscode = maintenance_setting('maintenance_passcode', '');

        if ($request->passcode === $storedPasscode) {
            $request->session()->put('maintenance_bypass', true);
            return redirect('/')->with('success', 'Access granted! Welcome back.');
        }

        return back()->withErrors(['passcode' => 'Invalid passcode. Please try again.']);
    }
}
