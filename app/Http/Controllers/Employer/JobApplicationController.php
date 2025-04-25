<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index()
    {
        $applications = JobApplication::whereHas('job', function($query) {
            $query->where('company_id', auth()->user()->company->id);
        })->with(['job', 'jobseeker.user'])->get();

        return view('employer.applications.index', compact('applications'));
    }

    public function show(JobApplication $application)
    {
        return view('employer.applications.show', compact('application'));
    }

    public function updateStatus(Request $request, JobApplication $application)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected'
        ]);

        $application->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Application status updated successfully!');
    }
} 