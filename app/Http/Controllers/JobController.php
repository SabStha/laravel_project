<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\TJobEvaluationAxis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



class JobController extends Controller
{
    
    public function create()
    {
        if (auth()->check()) {
            $employer = auth()->user()->employer;
            return view('jobformview', compact('employer'));
        }

        return redirect()->route('login');
    }

    public function store(Request $request)
    {
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
            'evaluation' => 'required|array',
            'evaluation.*' => 'required|integer|min:1|max:5'
        ]);

           

        try {
            $employer = auth()->user()->employer;

            if (!$employer) {
                return back()->withErrors('Error: You must be an employer to create a job.');
            }

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('job_images', 'public');
            }
            

            // ✅ Create Job entry
            $job = Job::create([
                'employer_id' => $employer->id,
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

            // ✅ Insert Evaluation requirements into database
            foreach ($validated['evaluation'] as $axisId => $rating) {
                TJobEvaluationAxis::create([
                    'job_id' => $job->id,
                    'evaluation_axis_id' => $axisId,
                    'rating' => $rating,
                ]);
            }

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

        if (auth()->user()->employer->id !== $job->employer_id) {
            return redirect()->route('jobs.index')->with('error', 'You are not authorized to edit this job.');
        }

        return view('jobsEdit', compact('job'));
    }

    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        if (auth()->user()->employer->id !== $job->employer_id) {
            return redirect()->route('jobs.index')->with('error', 'You are not authorized to update this job.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|string|max:255',
        ]);

        $job->update($request->only(['title', 'description', 'location', 'salary']));

        return redirect()->route('viewJobsindex')->with('success', 'Job updated successfully.');
    }
}
