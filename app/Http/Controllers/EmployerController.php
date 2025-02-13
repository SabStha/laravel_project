<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employer;
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
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:255',
            'company_phone' => 'required|string|max:20',
        ]);

        // Use DB transaction to ensure both user and employer records are created
        try {
            DB::transaction(function() use ($validated, $request) {
                // Create the user
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'user_type' => 'employer',
                ]);

                // Create the employer profile
                $employer = Employer::create([
                    'user_id' => $user->id,
                    'company_name' => $validated['company_name'],
                    'company_address' => $validated['company_address'],
                    'company_phone' => $validated['company_phone'],
                    'status' => 'pending', // Default status for new employers
                ]);
            });

            // Redirect with success message
            return redirect()->route('employer.dashboard')
                           ->with('success', '登録が完了しました。管理者の承認をお待ちください。');
        } catch (\Exception $e) {
            // If something goes wrong, redirect back with error
            return back()->withInput()
                        ->withErrors(['error' => '登録に失敗しました。もう一度お試しください。']);
        }
    }

    public function dashboard()
    {
        return view('employer_dashboard'); // Ensure you have this Blade view
    }
}
