<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsJobseeker
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->isJobseeker()) {
            return $next($request);
        }

        return redirect('/'); // or any other route
    }
}