<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\Jobseeker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    /**
     * Display a listing of jobseekers with their survey results.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $jobseekers = DB::table('jobseekers')
            ->leftJoin('users', 'jobseekers.user_id', '=', 'users.id')
            ->select('jobseekers.id', 'users.name', 'users.email', 'jobseekers.total_score', 'jobseekers.survey_completed')
            ->orderByDesc('jobseekers.total_score')
            ->get();

        return view('operator.surveys.index', compact('jobseekers'));
    }

    /**
     * Display the specified jobseeker's survey details.
     *
     * @param  int  $jobseeker_id
     * @return \Illuminate\View\View
     */
    public function show($jobseeker_id)
    {
        $jobseeker = DB::table('jobseekers')
            ->leftJoin('users', 'jobseekers.user_id', '=', 'users.id')
            ->where('jobseekers.id', $jobseeker_id)
            ->select('jobseekers.*', 'users.name', 'users.email')
            ->first();

        $survey_responses = DB::table('jobseeker_survey')
            ->leftJoin('surveys', 'jobseeker_survey.survey_id', '=', 'surveys.id')
            ->where('jobseeker_survey.jobseeker_id', $jobseeker_id)
            ->select('surveys.question_text', 'jobseeker_survey.selected_option', 'jobseeker_survey.score')
            ->get();

        return view('operator.surveys.show', compact('jobseeker', 'survey_responses'));
    }
} 