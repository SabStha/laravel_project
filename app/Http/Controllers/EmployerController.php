<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employer;
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
                'user_type' => 'employer',
            ]);
            
            $user->employer()->create([
                'user_id' => $user->id, // Foreign key to the users table
            ]);
        });
        return redirect()->route('employer.dashboard');
    }
}
