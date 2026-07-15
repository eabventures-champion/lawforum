<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MaintenanceMode
{
    /**
     * Handle an incoming request.
     * Redirects all public traffic to the maintenance page when maintenance mode is enabled,
     * unless the user has bypassed with a valid passcode or is accessing admin/maintenance routes.
     */
    public function handle(Request $request, Closure $next)
    {
        // Never block these paths
        if ($this->isExempt($request)) {
            return $next($request);
        }

        // Check if maintenance mode is enabled
        try {
            $enabled = maintenance_setting('maintenance_enabled', false);
        } catch (\Exception $e) {
            // Table may not exist yet — allow through
            return $next($request);
        }

        if (!$enabled) {
            return $next($request);
        }

        // If user has a valid bypass session, allow through
        if ($request->session()->get('maintenance_bypass') === true) {
            return $next($request);
        }

        // Redirect to maintenance page
        return redirect()->route('maintenance.show');
    }

    /**
     * Determine if the request is exempt from maintenance mode.
     */
    protected function isExempt(Request $request): bool
    {
        $path = $request->path();

        // Always allow admin routes (so admins can toggle it off)
        if (str_starts_with($path, 'admin')) {
            return true;
        }

        // Always allow the maintenance page itself and its verify endpoint
        if ($path === 'maintenance' || $path === 'maintenance/verify') {
            return true;
        }

        // Allow login/logout so admins can authenticate
        if (in_array($path, ['login', 'logout', 'register'])) {
            return true;
        }

        // Allow asset files (css, js, images, fonts)
        if (preg_match('/\.(css|js|ico|png|jpg|jpeg|gif|svg|woff2?|ttf|eot|map)$/i', $path)) {
            return true;
        }

        return false;
    }
}
