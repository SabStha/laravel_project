<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Jobseeker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JobseekerController extends Controller
{
    /**
     * Display a listing of jobseekers with filtering options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        Log::info('View Jobseekers - Request Parameters', $request->all());

        // Log raw queries being executed
        DB::listen(function ($query) {
            Log::info('SQL Query', ['sql' => $query->sql, 'bindings' => $query->bindings]);
        });

        $graduationDates = Jobseeker::whereNotNull('expected_to_graduate')
            ->selectRaw("DATE_FORMAT(expected_to_graduate, '%Y-%m') as grad_month")
            ->distinct()
            ->orderBy('grad_month', 'desc')
            ->pluck('grad_month');

        $schools = Jobseeker::whereNotNull('school')->distinct()->pluck('school');
        $citizenships = Jobseeker::whereNotNull('citizenship')->distinct()->pluck('citizenship');
        $jlptLevels = Jobseeker::whereNotNull('jlpt')->distinct()->pluck('jlpt');
        $wages = Jobseeker::whereNotNull('wage')->distinct()->pluck('wage')->sort();

        $query = Jobseeker::with('user');

        // Apply filters
        $this->applyFilters($query, $request);

        $jobseekers = $query->paginate(10);

        return view('operator.jobseekers.index', compact(
            'jobseekers',
            'graduationDates',
            'schools',
            'citizenships',
            'jlptLevels',
            'wages'
        ));
    }

    /**
     * Show the specified jobseeker's details.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $jobseeker = Jobseeker::with('user', 'surveyResponses.survey')->findOrFail($id);
        return view('operator.jobseekers.show', compact('jobseeker'));
    }

    /**
     * Apply filters to the jobseeker query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    private function applyFilters($query, $request)
    {
        if ($request->filled('name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->name . '%');
            });
        }

        if ($request->filled('email')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('email', 'LIKE', '%' . $request->email . '%');
            });
        }

        if ($request->filled('school')) {
            $query->where('school', $request->school);
        }

        if ($request->filled('citizenship')) {
            $query->where('citizenship', $request->citizenship);
        }

        if ($request->filled('jlpt')) {
            $query->where('jlpt', $request->jlpt);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('graduation_date')) {
            $query->whereRaw("DATE_FORMAT(expected_to_graduate, '%Y-%m') = ?", [$request->graduation_date]);
        }
    }
} 