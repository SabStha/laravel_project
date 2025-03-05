<?php



namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperatorMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->user_type === 'operator') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Access denied! You are not an operator.');
    }
}
