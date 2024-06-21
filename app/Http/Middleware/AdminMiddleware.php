<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && ($user->role_id == 1 || $user->role_id == 2)) {
            return $next($request);
        }

        // Redirect to 404 if user role_id is not 1 or 2
        if ($user && $user->role_id != 1 && $user->role_id != 2) {
            return abort(404); // Show 404 page for unauthorized access
        }

        // Redirect to dashboard if user is not authenticated or does not have the correct role
        return redirect('/dashboard');
    }
}
