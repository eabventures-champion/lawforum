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
