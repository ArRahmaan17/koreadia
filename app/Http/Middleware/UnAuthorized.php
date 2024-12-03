<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UnAuthorized
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (empty(auth()->user())) {
            return $next($request);
        } elseif (! auth()->user()->valid) {
            return redirect()->route('validation-process');
        } else {
            return redirect()->route('home');
        }
    }
}
