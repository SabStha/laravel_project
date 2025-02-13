<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated and email is NOT verified
        if (Auth::check() && !$request->user()->hasVerifiedEmail()) {
            Auth::logout(); // Force logout if not verified
            return redirect()->route('verification.notice')
                ->with('error', 'You must verify your email before accessing the application.');
        }

        return $next($request);
    }
}
