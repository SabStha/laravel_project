<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Survey;

class DashboardController extends Controller
{
    /**
     * Show the operator dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_jobs' => Job::count(),
            'total_applications' => JobApplication::count(),
            'total_surveys' => Survey::count(),
            'recent_jobs' => Job::latest()->take(5)->get(),
            'recent_applications' => JobApplication::with(['job', 'jobseeker.user'])->latest()->take(5)->get(),
        ];

        return view('operator.dashboard.index', compact('stats'));
    }

    /**
     * Show the operator listings page.
     *
     * @return \Illuminate\View\View
     */
    public function listings()
    {
        return view('operator.listings');
    }

    /**
     * Show the operator profile management page.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        return view('operator.profile');
    }

    /**
     * Show the operator applications page.
     *
     * @return \Illuminate\View\View
     */
    public function applications()
    {
        return view('operator.applications');
    }

    /**
     * Show the operator notifications page.
     *
     * @return \Illuminate\View\View
     */
    public function notifications()
    {
        return view('operator.notifications');
    }
} 