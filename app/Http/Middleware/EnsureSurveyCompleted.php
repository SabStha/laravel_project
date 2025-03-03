<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureSurveyCompleted
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // If user is a jobseeker and has NOT completed the survey, redirect to survey page
        if ($user && $user->jobseeker && !$user->jobseeker->survey_completed) {
            return redirect()->route('survey.show')->with('warning', 'You must complete the survey before accessing your dashboard.');
        }

        return $next($request);
    }
}
