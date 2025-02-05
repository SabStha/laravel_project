<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class JobseekerController extends Controller
{
    // Show the jobseeker registration form
    public function showRegistrationForm()
    {
        return view('jobseeker_register');
    }

    // Handle jobseeker registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'jobseeker', // Set user type to 'jobseeker'
        ]);

        // You can add additional logic here, like sending a welcome email or logging the user in.

        return redirect()->route('jobseeker.dashboard');
    }

    // Show the jobseeker dashboard
    public function dashboard()
    {
        return view('jobseeker_dashboard');
    }
}
