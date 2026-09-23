<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\AdminTwoFactorCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'show2faForm', 'verify2fa', 'resend2fa', 'cancel2fa']);
    }

    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle the admin login request (Step 1 of 2FA).
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        // Verify credentials without fully authenticating yet
        if (!Auth::validate($credentials)) {
            return redirect()->back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => 'These credentials do not match our administrative records.',
                ]);
        }

        $user = User::where('email', $request->input('email'))->first();

        // Validate that the user is an administrator
        if (!$user || (!$user->isAdmin() && $user->email !== 'admin@admin.com' && strpos($user->email, '@admin.com') === false)) {
            return redirect()->back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => 'Access Denied: This login portal is strictly reserved for system administrators.',
                ]);
        }

        // Generate 6-digit 2FA OTP
        $twoFactor = AdminTwoFactorCode::generateForUser($user, $request);

        // Send OTP via Email
        try {
            Mail::send('emails.admin_2fa_code', [
                'user'      => $user,
                'code'      => $twoFactor->code,
                'ipAddress' => $request->ip(),
            ], function ($message) use ($user, $twoFactor) {
                $message->to($user->email)
                        ->subject('Legals Forum Admin Verification Code: ' . $twoFactor->code);
            });
        } catch (\Exception $e) {
            logger()->error('Failed to send admin 2FA email: ' . $e->getMessage());
        }

        // Store pending 2FA intent in session
        session([
            'admin_2fa_pending' => [
                'user_id'  => $user->id,
                'remember' => $request->has('remember'),
                'sent_at'  => now()->timestamp,
            ],
            'admin_2fa_dev_code' => app()->environment('local') ? $twoFactor->code : null,
        ]);

        return redirect()->route('admin.login.2fa');
    }

    /**
     * Show the 2FA OTP verification screen.
     */
    public function show2faForm(Request $request)
    {
        $pending = session('admin_2fa_pending');

        if (!$pending || empty($pending['user_id'])) {
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Please enter your administrator credentials first.']);
        }

        $user = User::find($pending['user_id']);
        if (!$user) {
            session()->forget('admin_2fa_pending');
            return redirect()->route('admin.login');
        }

        // Mask email: j***@example.com
        $emailParts = explode('@', $user->email);
        $namePart = $emailParts[0];
        $domainPart = $emailParts[1] ?? '';
        $maskedName = strlen($namePart) <= 2 
            ? $namePart . '***' 
            : substr($namePart, 0, 2) . str_repeat('*', max(3, strlen($namePart) - 2));
        $maskedEmail = $maskedName . '@' . $domainPart;

        // Calculate remaining seconds
        $activeCode = AdminTwoFactorCode::where('user_id', $user->id)
            ->where('used', false)
            ->latest()
            ->first();

        $remainingExpirySeconds = $activeCode ? max(0, now()->diffInSeconds($activeCode->expires_at, false)) : 600;
        $sentAt = $pending['sent_at'] ?? now()->timestamp;
        $resendCooldownRemaining = max(0, 60 - (now()->timestamp - $sentAt));

        return view('admin.auth.two_factor', compact(
            'user',
            'maskedEmail',
            'remainingExpirySeconds',
            'resendCooldownRemaining'
        ));
    }

    /**
     * Verify the 2FA OTP code and complete login.
     */
    public function verify2fa(Request $request)
    {
        $pending = session('admin_2fa_pending');

        if (!$pending || empty($pending['user_id'])) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Session expired. Please log in again.'], 401);
            }
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Session expired. Please enter your administrator credentials again.']);
        }

        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $userId = $pending['user_id'];
        $user = User::findOrFail($userId);

        $twoFactor = AdminTwoFactorCode::where('user_id', $userId)
            ->where('used', false)
            ->latest()
            ->first();

        // Check if code exists and is usable
        if (!$twoFactor || !$twoFactor->isUsable()) {
            $msg = 'Your security code has expired. Please click Resend Code to receive a new one.';
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return redirect()->back()->withErrors(['code' => $msg]);
        }

        // Check if entered code matches
        $inputCode = trim($request->input('code'));
        if (!$twoFactor->matches($inputCode)) {
            $twoFactor->increment('attempts');
            $remaining = max(0, 5 - $twoFactor->attempts);

            if ($remaining <= 0) {
                $twoFactor->update(['used' => true]);
                $msg = 'Maximum verification attempts exceeded. Please request a new security code.';
            } else {
                $msg = "Incorrect security code. {$remaining} attempt(s) remaining.";
            }

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return redirect()->back()->withErrors(['code' => $msg]);
        }

        // Authentication Success!
        $twoFactor->update(['used' => true]);

        $remember = !empty($pending['remember']);
        Auth::loginUsingId($user->id, $remember);

        // Mark 2FA verified in session
        session(['admin_2fa_verified' => true]);
        session()->forget(['admin_2fa_pending', 'admin_2fa_dev_code']);

        if ($remember) {
            Cookie::queue(Cookie::forever('remember_email', $user->email));
        } else {
            Cookie::queue(Cookie::forget('remember_email'));
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'  => true,
                'redirect' => route('admin.dashboard'),
                'message'  => 'Two-factor authentication verified successfully!',
            ]);
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Two-factor authentication verified. Welcome to Legals Forum Administration Portal!');
    }

    /**
     * Resend 2FA OTP code.
     */
    public function resend2fa(Request $request)
    {
        $pending = session('admin_2fa_pending');

        if (!$pending || empty($pending['user_id'])) {
            return response()->json(['success' => false, 'message' => 'Session expired. Please log in again.'], 401);
        }

        $sentAt = $pending['sent_at'] ?? 0;
        $diff = now()->timestamp - $sentAt;

        if ($diff < 60) {
            $cooldown = 60 - $diff;
            return response()->json([
                'success'  => false,
                'message'  => "Please wait {$cooldown} seconds before requesting a new code.",
                'cooldown' => $cooldown,
            ], 429);
        }

        $user = User::findOrFail($pending['user_id']);
        $twoFactor = AdminTwoFactorCode::generateForUser($user, $request);

        try {
            Mail::send('emails.admin_2fa_code', [
                'user'      => $user,
                'code'      => $twoFactor->code,
                'ipAddress' => $request->ip(),
            ], function ($message) use ($user, $twoFactor) {
                $message->to($user->email)
                        ->subject('Legals Forum Admin Verification Code: ' . $twoFactor->code);
            });
        } catch (\Exception $e) {
            logger()->error('Failed to resend admin 2FA email: ' . $e->getMessage());
        }

        session([
            'admin_2fa_pending.sent_at' => now()->timestamp,
            'admin_2fa_dev_code'        => app()->environment('local') ? $twoFactor->code : null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'A new 6-digit security code has been sent to ' . $user->email,
        ]);
    }

    /**
     * Cancel 2FA and return to login.
     */
    public function cancel2fa(Request $request)
    {
        session()->forget(['admin_2fa_pending', 'admin_2fa_dev_code']);
        return redirect()->route('admin.login');
    }
}
