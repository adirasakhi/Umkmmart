<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
// Example of how `dd()` might show `null` in AdminMiddleware.php

public function handle($request, Closure $next)
{
    $user = Auth::user();
    dd($user); // Assuming $user is null at this point

    // Other middleware logic
    return $next($request);
}

}
