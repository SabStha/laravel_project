<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function jobseekerDashboard()
    {
        return view('jobseeker.dashboard.index');
    }

    public function employerDashboard()
    {
        return view('employer.dashboard.index');
    }

    public function index()
    {
        return view('operator.dashboard.index');
    }
} 