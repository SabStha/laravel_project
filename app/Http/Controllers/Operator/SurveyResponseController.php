<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;

class SurveyResponseController extends Controller
{
    public function index()
    {
        $responses = SurveyResponse::with(['survey', 'jobseeker.user'])->latest()->paginate(10);
        return view('operator.survey-responses.index', compact('responses'));
    }

    public function show(SurveyResponse $response)
    {
        $response->load(['survey', 'jobseeker.user', 'question']);
        return view('operator.survey-responses.show', compact('response'));
    }

    public function edit(SurveyResponse $response)
    {
        $response->load(['survey', 'jobseeker.user', 'question']);
        return view('operator.survey-responses.edit', compact('response'));
    }

    public function update(Request $request, SurveyResponse $response)
    {
        $validated = $request->validate([
            'score' => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string|max:1000'
        ]);

        $response->update($validated);

        return redirect()->route('operator.survey-responses.show', $response)
            ->with('success', 'Survey response updated successfully!');
    }
} 