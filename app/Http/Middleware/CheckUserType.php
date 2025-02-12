<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$user_type): Response
    {
        if(auth()->check()&&auth()->user()->user_type==$user_type){
            return $next($request);
        }
        return redirect()->route('home')->with('error', 'You do not have the correct permissions.');

    }
}
