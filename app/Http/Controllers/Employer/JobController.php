<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = auth()->user()->company->jobs;
        return view('employer.job.index', compact('jobs'));
    }

    public function create()
    {
        return view('employer.job.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'salary' => 'required|numeric',
            'location' => 'required|string|max:255',
        ]);

        auth()->user()->company->jobs()->create($validated);

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job posted successfully!');
    }

    public function show(Job $job)
    {
        return view('employer.job.show', compact('job'));
    }

    public function edit(Job $job)
    {
        return view('employer.job.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'salary' => 'required|numeric',
            'location' => 'required|string|max:255',
        ]);

        $job->update($validated);

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job updated successfully!');
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('employer.jobs.index')
            ->with('success', 'Job deleted successfully!');
    }
} 