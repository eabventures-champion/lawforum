<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle the admin login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $user = Auth::user();

            // Validate that the user is an administrator
            // (either email is admin@admin.com or ends with @admin.com, or has isAdmin() equivalent check)
            if ($user->email === 'admin@admin.com' || strpos($user->email, '@admin.com') !== false) {
                // Redirect directly to the admin laws dashboard
                return redirect()->route('admin.laws.index')
                    ->with('success', 'Welcome to Legals Forum Administration Portal!');
            }

            // Log out non-admin users and reject them
            Auth::logout();
            return redirect()->back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => 'Access Denied: This login portal is strictly reserved for system administrators.',
                ]);
        }

        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'These credentials do not match our administrative records.',
            ]);
    }
}
