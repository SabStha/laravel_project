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
        // Proceed with storing the job if validation passes
        try {
            // Handle the image upload if exists
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('job_images', 'public');
            }

            // Create the job
            Job::create([
                'employer_id' => auth()->id(),
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

            // Redirect with success message
            return redirect()->route('employer.dashboard')
                ->with('success', '登録が完了しました。管理者の承認をお待ちください。');

        } catch (\Exception $e) {
            // Log the error if the job creation fails
            Log::error('Job creation failed', [
                'exception' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return back()->withErrors('An error occurred while creating the job. Please try again.');
        }
    }


}
