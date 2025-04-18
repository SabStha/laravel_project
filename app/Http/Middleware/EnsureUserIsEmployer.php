<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;

// class EnsureUserIsEmployer
// {
//     public function handle(Request $request, Closure $next)
//     {
//         if (auth()->check() && auth()->user()->isEmployer()) {
//             return $next($request);
//         }

//         return redirect('/'); // or any other route
//     }
// }