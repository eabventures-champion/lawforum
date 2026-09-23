<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            // Bypass during automated testing or leave-impersonation flows
            if (app()->environment('testing') || session('admin_2fa_verified', false) || session('impersonating_admin_id')) {
                return $next($request);
            }

            // If 2FA is already pending, redirect to verification screen
            if (session('admin_2fa_pending')) {
                return redirect()->route('admin.login.2fa');
            }

            // Generate and send 2FA OTP for the authenticated admin
            $user = Auth::user();
            $twoFactor = \App\AdminTwoFactorCode::generateForUser($user, $request);

            session([
                'admin_2fa_pending' => [
                    'user_id'  => $user->id,
                    'remember' => true,
                    'sent_at'  => now()->timestamp,
                ],
                'admin_2fa_dev_code' => app()->environment('local') ? $twoFactor->code : null,
            ]);

            try {
                \Illuminate\Support\Facades\Mail::send('emails.admin_2fa_code', [
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

            return redirect()->route('admin.login.2fa')
                ->with('info', 'Two-Factor Authentication is required to access the Administration Portal.');
        }

        abort(403, 'Unauthorized access.');
    }
}
