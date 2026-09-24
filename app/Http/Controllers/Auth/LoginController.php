<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * The user has been authenticated.
     * Intercept legacy users or unverified users and guide them appropriately.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        // Persist or clear remembered email cookie for login form pre-population
        if ($request->filled('remember')) {
            \Illuminate\Support\Facades\Cookie::queue(
                \Illuminate\Support\Facades\Cookie::forever('remember_email', $request->input('email'))
            );
        } else {
            \Illuminate\Support\Facades\Cookie::queue(
                \Illuminate\Support\Facades\Cookie::forget('remember_email')
            );
        }

        // Check if there is an active pending team invitation for this user
        $token = session('pending_team_invite_token');
        $invite = null;
        if ($token) {
            $invite = \App\SubscriptionTeamMember::where('invite_token', $token)->where('status', 'pending')->first();
        }
        if (!$invite && $user->email) {
            $invite = \App\SubscriptionTeamMember::where('email', strtolower($user->email))->where('status', 'pending')->first();
        }

        if ($invite) {
            $invite->update([
                'member_id' => $user->id,
                'status' => 'accepted',
                'accepted_at' => now(),
            ]);
            session()->forget(['pending_team_invite_token', 'pending_team_invite_email']);

            return redirect()->route('team.index')->with('status', 'Welcome back! You have joined the collaborative research team workspace.');
        }

        // 1. Admin users go straight to admin panel
        if ($user->isAdmin()) {
            return redirect()->intended('/admin');
        }

        // 2. Legacy users with no role assigned -> prompt role selection
        if (empty($user->user_type)) {
            return redirect()->route('account.upgrade.role');
        }

        // 3. Users whose email is not verified -> go to verification notice
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        // 4. Fully activated user -> intended dashboard
        return redirect()->intended('/home');
    }
}
