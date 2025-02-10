<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employer;  // Ensure you have the Employer model imported
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployerController extends Controller
{
    public function showRegistrationForm()
    {
        return view('employer_register');
    }

    public function register(Request $request)
    {
        // Validate the incoming request data and store it in $validated
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Use DB transaction to ensure data integrity
        DB::transaction(function() use ($validated) {
            // Create the user in the users table
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'user_type' => 'employer', // Set user type to 'employer'
            ]);

            // Create the employer in the employers table
            // Assuming you have an `employers` table and Employer model
            $user->employer()->create([
                'user_id' => $user->id, // Foreign key to the users table
                // Add other necessary fields for employer here, such as company name, etc.
            ]);
        });

        // Redirect to a specific page after successful registration
        return redirect()->route('employer.dashboard')->with('status', 'Registration successful');
    }

    public function dashboard()
{
    return view('employer_dashboard'); // Ensure you have this Blade view
}

}
