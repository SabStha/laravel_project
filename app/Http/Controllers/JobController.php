<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class JobController extends Controller
{
    public function create()
    {
        // Check if the user is authenticated
        if (auth()->check()) {
            // Retrieve authenticated employer's details if necessary
            $employer = auth()->user();
    
            // Return the job creation view
            return view('jobformview', compact('employer'));
        }
    
        // Redirect to login if not authenticated
        return redirect()->route('login');
    }

    public function store(Request $request)
{
    // Validate the form data
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'job_type' => 'required|string|in:full,part,contract',
        'working_days' => 'required|array',
        'working_hour' => 'required|string',
        'location' => 'required|string|max:255',
        'salary' => 'nullable|string|max:255',
        'required_skills' => 'nullable|string',
        'visa_required' => 'nullable|boolean',
    ]);

    try {
        // ✅ Get employer based on the authenticated user
        $employer = auth()->user()->employer;

        if (!$employer) {
            return back()->withErrors('Error: You must be an employer to create a job.');
        }

        // Handle the image upload if exists
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('job_images', 'public');
        }

        // ✅ Create the job with the correct employer_id
        Job::create([
            'employer_id' => $employer->id, // 🔥 This ensures correct linking
            'title' => $validated['title'],
            'description' => $validated['description'],
            'job_type' => $validated['job_type'],
            'working_days' => json_encode($validated['working_days']),
            'working_hours' => $validated['working_hour'],
            'location' => $validated['location'],
            'salary' => $validated['salary'],
            'required_skills' => $validated['required_skills'],
            'visa_required' => $validated['visa_required'] ?? 0,
            'image' => $imagePath,
        ]);

        return redirect()->route('employer.dashboard')
            ->with('success', '登録が完了しました。管理者の承認をお待ちください。');

    } catch (\Exception $e) {
        Log::error('Job creation failed', [
            'exception' => $e->getMessage(),
            'request_data' => $request->all(),
        ]);
        return back()->withErrors('An error occurred while creating the job. Please try again.');
    }
}

    public function index()
    {
        $user = auth()->user();

        if (!$user->employer || $user->employer->status !== 'registered') {
            return redirect()->route('employer.completeRegistrationForm')
                ->with('error', 'You must complete registration before viewing jobs.');
        }

        // Fetch jobs only created by this employer
        $jobs = $user->employer->jobs()->latest()->paginate(10);

        return view('viewJobsindex', compact('jobs'));
    }

    public function show($id)
    {
        $job = Job::findOrFail($id);

        return view('jobsShow', compact('job'));
    }

    public function edit($id)
{
    $job = Job::findOrFail($id);
    
    // Ensure only the employer who posted the job can edit
    if (auth()->user()->id !== $job->employer_id) {
        return redirect()->route('jobs.index')->with('error', 'You are not authorized to edit this job.');
    }

    return view('jobsEdit', compact('job'));
}

public function update(Request $request, $id)
{
    $job = Job::findOrFail($id);

    if (auth()->user()->id !== $job->employer_id) {
        return redirect()->route('jobs.index')->with('error', 'You are not authorized to update this job.');
    }

    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'location' => 'required|string|max:255',
        'salary' => 'nullable|string|max:255',
    ]);

    $job->update($request->all());

    return redirect()->route('viewJobsindex')->with('success', 'Job updated successfully.');
}







}
