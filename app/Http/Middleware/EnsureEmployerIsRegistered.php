<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureEmployerIsRegistered
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Ensure the user is an employer and has completed registration
        if ($user->user_type === 'employer' && (!$user->employer || $user->employer->status !== 'registered')) {
            return redirect()->route('employer.completeRegistrationForm')
                ->with('error', 'You must complete your business registration before posting jobs.');
        }

        return $next($request);
    }
}
