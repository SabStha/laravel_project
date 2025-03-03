<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Jobseeker;

class SurveyController extends Controller
{


    public function submitSurvey(Request $request)
    {
        $user = auth()->user();

        if (!$user->jobseeker) {
            return redirect()->route('survey.show')->with('error', 'You need a jobseeker profile to take the survey.');
        }

        $jobseeker = $user->jobseeker;

        // Prevent duplicate survey entries
        if ($jobseeker->survey_completed) {
            return redirect()->route('jobseeker.dashboard')->with('info', 'You have already completed the survey.');
        }

        foreach ($request->responses as $survey_id => $selected_option) {
            $score = match($selected_option) {
                'a' => 10,
                'b' => 7,
                'c' => 5,
                'd' => 3,
                default => 0,
            };

            $jobseeker->surveys()->attach($survey_id, [
                'selected_option' => $selected_option,
                'score' => $score
            ]);
        }

        // Ensure the survey is marked as completed
        $jobseeker->update(['survey_completed' => true]);

        return redirect()->route('jobseeker.dashboard')->with('success', 'Survey submitted successfully!');
    }

        public function showSurvey()
    {
        $user = auth()->user();

        if (!$user->jobseeker) {
            return redirect()->route('jobseeker.dashboard')->with('error', 'Only jobseekers can access the survey.');
        }

        if ($user->jobseeker->survey_completed) {
            return redirect()->route('jobseeker.dashboard')->with('info', 'You have already completed the survey.');
        }

        $surveys = Survey::all();
        return view('survey', compact('surveys'));
    }

    public function viewResponses()
    {
        $jobseekers = Jobseeker::leftJoin('users', 'jobseekers.user_id', '=', 'users.id')
            ->select('jobseekers.id', 'users.name', 'users.email', 'jobseekers.total_score', 'jobseekers.survey_completed')
            ->orderByDesc('jobseekers.total_score')
            ->get();

        return view('survey_results', compact('jobseekers'));
    }


    
}
