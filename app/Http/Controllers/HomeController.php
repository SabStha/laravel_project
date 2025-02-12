<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
    
        if ($user->user_type == 'employer') {
            return redirect()->route('employer.dashboard');
        } elseif ($user->user_type == 'jobseeker') {
            return redirect()->route('jobseeker.dashboard');
        } elseif ($user->user_type == 'operator') {
            return redirect()->route('operator.dashboard');
        }
    
        return view('welcome'); // Default view if no role is matched
    }
    
}