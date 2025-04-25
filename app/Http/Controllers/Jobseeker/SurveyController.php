<?php

namespace App\Http\Controllers\Jobseeker;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::with('questions')->get();
        return view('jobseeker.survey.index', compact('surveys'));
    }

    public function show(Survey $survey)
    {
        return view('jobseeker.survey.show', compact('survey'));
    }

    public function store(Request $request, Survey $survey)
    {
        $jobseeker = auth()->user()->jobseeker;

        foreach ($request->responses as $questionId => $response) {
            SurveyResponse::create([
                'jobseeker_id' => $jobseeker->id,
                'survey_id' => $survey->id,
                'question_id' => $questionId,
                'response' => $response
            ]);
        }

        $jobseeker->update(['survey_completed' => true]);

        return redirect()->route('jobseeker.dashboard')
            ->with('success', 'Survey completed successfully!');
    }

    public function results()
    {
        $jobseeker = auth()->user()->jobseeker;
        $responses = $jobseeker->surveyResponses()->with('survey', 'question')->get();
        return view('jobseeker.survey.results', compact('responses'));
    }
} 