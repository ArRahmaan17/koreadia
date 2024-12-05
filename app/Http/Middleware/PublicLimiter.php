<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class PublicLimiter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user() == null) {
            if (RateLimiter::tooManyAttempts('store-mail:' . $request->ip, $perMinute = 5)) {
                $seconds = RateLimiter::availableIn('store-mail:' . $request->ip);
                return response()->json(['message' => 'Terlalu Banyak Percobaan! Coba lagi dalam ' . $seconds . ' detik.'], 429);
            }
            RateLimiter::increment('store-mail:' . $request->ip);
            return $next($request);
        } else {
            return $next($request);
        }
    }
}
