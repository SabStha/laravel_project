<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
<<<<<<< HEAD
use App\Models\Employer;  // Ensure you have the Employer model imported
use Illuminate\Support\Facades\DB;
=======
use App\Models\Employer;
>>>>>>> 0302e1f94658b32a941265da47d40f5873256a35
use Illuminate\Support\Facades\Hash;
use DB;

class EmployerController extends Controller
{
    public function showRegistrationForm()
    {
        return view('employer_register');
    }

    public function register(Request $request)
    {
<<<<<<< HEAD
        // Validate the incoming request data and store it in $validated
=======

>>>>>>> 0302e1f94658b32a941265da47d40f5873256a35
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

<<<<<<< HEAD
        // Use DB transaction to ensure data integrity
=======
        // Use DB transaction to ensure both user and jobseeker records are created
>>>>>>> 0302e1f94658b32a941265da47d40f5873256a35
        DB::transaction(function() use ($validated) {
            // Create the user in the users table
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
<<<<<<< HEAD
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

=======
                'user_type' => 'employer',
            ]);
            
            $user->employer()->create([
                'user_id' => $user->id, // Foreign key to the users table
            ]);
        });
        return redirect()->route('employer.dashboard');
    }
>>>>>>> 0302e1f94658b32a941265da47d40f5873256a35
}
