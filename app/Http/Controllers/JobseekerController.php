<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jobseeker;  // Make sure the Jobseeker model is imported
use Illuminate\Support\Facades\Hash;
use DB;

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
        // Validate the input data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Use DB transaction to ensure both user and jobseeker records are created
        DB::transaction(function() use ($validated) {
            // Create the user in the users table
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'user_type' => 'jobseeker', // Set user type to 'jobseeker'
            ]);

            // Create the jobseeker in the jobseekers table
            // Assuming you have a `jobseekers` table and Jobseeker model
            $user->jobseeker()->create([
                'user_id' => $user->id, // Foreign key to the users table
                // Add other necessary fields for jobseeker here
            ]);
        });

        // After successful registration, redirect to the jobseeker dashboard
        return redirect()->route('jobseeker.dashboard');
    }

    // Show the jobseeker dashboard
    public function dashboard()
    {
        return view('jobseeker_dashboard');
    }
}
