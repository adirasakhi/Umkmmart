<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Carbon\Carbon;

class LogVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->path(), ['/', 'katalog'])) {
            $ipAddress = $request->ip();
            $lastVisit = Visitor::where('ip_address', $ipAddress)
                ->orderBy('visited_at', 'desc')
                ->first();

            if (!$lastVisit || $lastVisit->visited_at->diffInDays(Carbon::now()) >= 1) {
                Visitor::create([
                    'ip_address' => $ipAddress,
                    'visited_at' => Carbon::now(),
                ]);
            }
        }

        return $next($request);
    }
}
