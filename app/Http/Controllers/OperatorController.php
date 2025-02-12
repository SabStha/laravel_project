<?php

namespace App\Http\Controllers;

use App\Models\User; // Ensure you import the User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Import the Hash facade
use Illuminate\Support\Facades\Auth; // Import Auth for redirect after registration

class OperatorController extends Controller
{
    public function showRegistrationForm()
    {
        return view('operator_register'); // Return the registration view
    }

    public function register(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new user with the validated data
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'user_type' => 'operator', // Set user type as operator
        ]);

        // Log the user in after registration (optional)
        Auth::login($user);

        // Redirect the user to the operator dashboard or another page
        return redirect()->route('operator.dashboard');
    }
}
