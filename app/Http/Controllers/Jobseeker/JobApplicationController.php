<?php

namespace App\Http\Controllers\Jobseeker;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index()
    {
        $applications = auth()->user()->jobseeker->applications()->with('job.company')->get();
        return view('jobseeker.applications.index', compact('applications'));
    }

    public function store(Request $request, Job $job)
    {
        $jobseeker = auth()->user()->jobseeker;

        if ($jobseeker->applications()->where('job_id', $job->id)->exists()) {
            return redirect()->back()->with('error', 'You have already applied for this job.');
        }

        $jobseeker->applications()->create([
            'job_id' => $job->id,
            'status' => 'pending'
        ]);

        return redirect()->route('jobseeker.applications.index')
            ->with('success', 'Application submitted successfully!');
    }

    public function show(JobApplication $application)
    {
        return view('jobseeker.applications.show', compact('application'));
    }

    public function destroy(JobApplication $application)
    {
        $application->delete();
        return redirect()->route('jobseeker.applications.index')
            ->with('success', 'Application withdrawn successfully!');
    }
} 