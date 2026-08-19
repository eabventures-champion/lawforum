<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestAccessMiddleware
{
    /**
     * Routes that are exempt from the guest gate.
     * Users can access these even without clicking "Continue as Guest".
     */
    protected $exemptRoutes = [
        'get-started',
        'set-guest-access',
        'login',
        'register',
        'register/*',
        'password/*',
        'email/*',
        'admin',
        'admin/*',
        'maintenance',
        'maintenance/*',
        'main_home_search',
        'main_home_search/*',
        'search-history',
        'search-history/*',
    ];

    /**
     * Handle an incoming request.
     *
     * If the user is not authenticated and hasn't accepted guest access,
     * redirect them to the /get-started gateway page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Authenticated users always pass through
        if (Auth::check()) {
            return $next($request);
        }

        // Check if the current route is exempt
        $path = trim($request->path(), '/');

        // Homepage is always accessible
        if ($path === '' || $path === '/') {
            return $next($request);
        }

        foreach ($this->exemptRoutes as $exempt) {
            if ($path === $exempt || fnmatch($exempt, $path)) {
                return $next($request);
            }
        }

        // Check if guest access cookie exists
        if ($request->cookie('guest_access')) {
            return $next($request);
        }

        // For AJAX / JSON requests, return JSON rather than redirecting to HTML page
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['guest_required' => true, 'redirect' => '/get-started'], 401);
        }

        // Redirect to gateway page
        return redirect('/get-started');
    }
}
