<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use App\Models\Jobseeker;
use App\Models\EvaluationAxis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
    /**
     * Display a listing of jobseekers with their evaluation status.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $jobseekers = DB::table('jobseekers')
            ->leftJoin('users', 'jobseekers.user_id', '=', 'users.id')
            ->select('jobseekers.*', 'users.name', 'users.email')
            ->get();

        // Fetch evaluation statuses
        foreach ($jobseekers as $jobseeker) {
            $jobseeker->isEvaluated = DB::table('t_jobseeker_evaluations')
                ->where('jobseeker_id', $jobseeker->id)
                ->exists();
        }

        return view('operator.evaluations.index', compact('jobseekers'));
    }

    /**
     * Show the form for creating a new evaluation.
     *
     * @param  int  $user_id
     * @return \Illuminate\View\View
     */
    public function create($user_id)
    {
        $jobseeker = Jobseeker::where('user_id', $user_id)->firstOrFail();
        $evaluation_axes = DB::table('m_evaluation_axes')->get();

        $existingEvaluations = DB::table('t_jobseeker_evaluations')
            ->join('m_evaluation_axes', 't_jobseeker_evaluations.evaluation_axis_id', '=', 'm_evaluation_axes.id')
            ->where('t_jobseeker_evaluations.jobseeker_id', $jobseeker->id)
            ->select('m_evaluation_axes.name as axis_name', 't_jobseeker_evaluations.rating')
            ->get();

        return view('operator.evaluations.create', compact('jobseeker', 'evaluation_axes', 'existingEvaluations'));
    }

    /**
     * Show the form for editing an existing evaluation.
     *
     * @param  int  $user_id
     * @return \Illuminate\View\View
     */
    public function edit($user_id)
    {
        $jobseeker = Jobseeker::findOrFail($user_id);
        $evaluation_axes = DB::table('m_evaluation_axes')->get();

        $existingEvaluations = DB::table('t_jobseeker_evaluations')
            ->join('m_evaluation_axes', 't_jobseeker_evaluations.evaluation_axis_id', '=', 'm_evaluation_axes.id')
            ->where('t_jobseeker_evaluations.jobseeker_id', $user_id)
            ->select('m_evaluation_axes.name as axis_name', 't_jobseeker_evaluations.rating')
            ->get();

        return view('operator.evaluations.edit', compact('jobseeker', 'evaluation_axes', 'existingEvaluations'));
    }
} 