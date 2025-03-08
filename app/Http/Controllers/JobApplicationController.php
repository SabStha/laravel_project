<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Models\JobApplication;
use App\Notifications\JobseekerDoesNotMeetRequirements;
use App\Notifications\JobApplicationNotMatchingRequirements;
use App\Models\TJobseekerEvaluation;
use App\Models\Notifications;


class JobApplicationController extends Controller
{
    public function applyForJob(Request $request, Job $job)
{
    $jobseeker = auth()->user()->jobseeker;

    // Check if the jobseeker meets the evaluation criteria
    $jobEvaluations = $job->jobEvaluationAxes;

    $mismatch = false;
    foreach ($jobEvaluations as $jobEval) {
        $jobseekerEval = TJobseekerEvaluation::where([
            'jobseeker_id' => $jobseeker->id,
            'evaluation_axis_id' => $jobEval->evaluation_axis_id
        ])->first();

        if (!$jobseekerEval || $jobseekerEval->rating < $jobEval->rating) {
            $mismatch = true;
            break;
        }
    }

    // Store the job application
    JobApplication::create([
        'job_id' => $job->id,
        'jobseeker_id' => $jobseeker->id,
        'status' => 'pending',
    ]);

    // Trigger Notifications clearly
    if ($mismatch) {
        // Notify Jobseeker
        Notification::create([
            'user_id' => $jobseeker->user_id,
            'message' => 'Your evaluation ratings do not match some job requirements.'
        ]);

        // Notify employer clearly
        Notification::create([
            'user_id' => $job->employer->user_id,
            'message' => 'An applicant applied who doesn’t meet all criteria.',
        ]);
    }

    return redirect()->route('jobseeker.dashboard')
        ->with('success', 'Application submitted successfully.');
}
}
