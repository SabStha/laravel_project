<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Job;

class HomeController extends Controller
{
    public function index()
    {
        $jobs = Job::latest()->take(6)->get();
        return view('shared.index', compact('jobs'));
    }

    public function welcome()
    {
        return view('shared.welcome');
    }
} 