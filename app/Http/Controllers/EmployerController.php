<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\BusinessCategory;
use App\Models\Task;
use App\Http\Controllers\Exception;
use Illuminate\Support\Str;
use App\Mail\EmployerVerificationMail;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Support\Facades\Log; // Import the Log facade


use Illuminate\Support\Facades\Mail;

class EmployerController extends Controller
{
    public function showRegistrationForm()
    {
        return view('employer_register');
    }

    

    public function register(Request $request)
{
    Log::info("🔥 Employer Registration Attempt", ['data' => $request->all()]);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'company_name' => 'required|string|max:255',
        'company_address' => 'required|string|max:255',
        'company_phone' => 'required|string|max:20',
    ]);

    Log::info("✅ Validation Passed", ['data' => $validated]);

    try {
        DB::transaction(function () use ($validated) {
            Log::info("🔄 Transaction Started");

            // Generate secure random password
            $randomPassword = Str::random(12);
            Log::info("🔑 Random Password Generated: $randomPassword");

            // Generate verification token
            $verificationToken = Str::uuid()->toString();
            Log::info("🔗 Generated Verification Token: $verificationToken");

            // Create the user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($randomPassword), // Securely hash password
                'user_type' => 'employer',
            ]);
            Log::info("👤 User Created: ID " . $user->id);

            // Create the employer profile
            $employer = Employer::create([
                'user_id' => $user->id,
                'company_name' => $validated['company_name'],
                'company_address' => $validated['company_address'],
                'company_phone' => $validated['company_phone'],
                'status' => 'pending',
                'verification_token' => $verificationToken,
            ]);
            Log::info("🏢 Employer Profile Created: ID " . $employer->id);

            // Generate verification link
            $verificationLink = url("/employer/complete-registration/{$verificationToken}");
            Log::info("📩 Generated Verification Link: $verificationLink");

            // Send email
            Mail::to($user->email)->send(new EmployerVerificationMail($user, $randomPassword, $verificationLink));
            Log::info("📨 Email Sent to " . $user->email);
        });

        return redirect()->route('employer.dashboard')->with('success', 'Employer registered successfully. They will receive an email with further instructions.');
    } catch (\Exception $e) {
        Log::error("❌ Registration Failed", ['error' => $e->getMessage()]);
        return back()->withInput()->withErrors(['error' => 'Registration failed. Please try again.']);
    }
}

    
    

    public function dashboard()
    {
            return view('employer_dashboard'); // Ensure you have this Blade view
    }



    public function showCompleteRegistrationForm($token)
    {
        $employer = Employer::where('verification_token', $token)->firstOrFail();
    
        if (!$employer) {
            return redirect()->route('employer.dashboard')->with('error', 'Employer profile not found.');
        }
    
        $businessCategories = BusinessCategory::all();
        $tasks = Task::all();
    
        return view('employer.complete-registration', compact('employer', 'businessCategories', 'tasks', 'token'));
    }
    



public function storeCompleteRegistration(Request $request)
{
    $user = auth()->user();

    // If the employer is already registered, redirect them
    if ($user->employer && $user->employer->status === 'registered') {
        return redirect()->route('employer.dashboard')
            ->with('error', 'You have already completed your business registration.');
    }

    // Validate input fields
    $request->validate([
        'business_type' => 'required|string',
        'company_name' => 'required|string|max:255',
        'business_number' => 'required|string|max:255',
        'postal_code' => 'required|string|max:10',
        'prefecture' => 'required|string|max:255',
        'municipality' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'building_name' => 'nullable|string|max:255',
        'contact_phone' => 'required|string|max:20',
        'business_category_id' => 'required|exists:business_categories,id',
        'desired_work_id' => 'required|exists:tasks,id',
        'challenges' => 'nullable|string',
    ]);

    // Create or update employer profile
    $employer = $user->employer ?? new Employer();
    $employer->user_id = $user->id;
    $employer->company_name = $request->company_name;
    $employer->business_type = $request->business_type;
    $employer->business_number = $request->business_number;
    $employer->postal_code = $request->postal_code;
    $employer->prefecture = $request->prefecture;
    $employer->municipality = $request->municipality;
    $employer->address = $request->address;
    $employer->building_name = $request->building_name;
    $employer->contact_phone = $request->contact_phone;
    $employer->business_category_id = $request->business_category_id;
    $employer->desired_work_id = $request->desired_work_id;
    $employer->challenges = $request->challenges;
    $employer->status = 'registered'; // Mark as registered
    $employer->save();

    return redirect()->route('employer.dashboard')
        ->with('success', 'Business registration completed successfully.');
}

public function edit()
{
    $user = auth()->user();

    if (!$user->employer || $user->employer->status !== 'registered') {
        return redirect()->route('employer.completeRegistrationForm')
            ->with('error', 'You must complete registration before editing.');
    }

    $businessCategories = BusinessCategory::all();
    $tasks = Task::all();

    return view('edit-registration', compact('user', 'businessCategories', 'tasks'));
}

public function update(Request $request)
{
    $user = auth()->user();

    if (!$user->employer || $user->employer->status !== 'registered') {
        return redirect()->route('employer.completeRegistrationForm')
            ->with('error', 'You must complete registration before editing.');
    }

    $request->validate([
        'business_type' => 'required|string',
        'company_name' => 'required|string|max:255',
        'business_number' => 'required|string|max:255',
        'postal_code' => 'required|string|max:10',
        'prefecture' => 'required|string|max:255',
        'municipality' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'building_name' => 'nullable|string|max:255',
        'contact_phone' => 'required|string|max:20',
        'business_category_id' => 'required|exists:business_categories,id',
        'desired_work_id' => 'required|exists:tasks,id',
        'challenges' => 'nullable|string',
    ]);

    $employer = $user->employer;
    $employer->company_name = $request->company_name;
    $employer->business_type = $request->business_type;
    $employer->business_number = $request->business_number;
    $employer->postal_code = $request->postal_code;
    $employer->prefecture = $request->prefecture;
    $employer->municipality = $request->municipality;
    $employer->address = $request->address;
    $employer->building_name = $request->building_name;
    $employer->contact_phone = $request->contact_phone;
    $employer->business_category_id = $request->business_category_id;
    $employer->desired_work_id = $request->desired_work_id;
    $employer->challenges = $request->challenges;
    $employer->save();

    return redirect()->route('employer.dashboard')
        ->with('success', 'Business registration updated successfully.');
}

public function adminRegisterEmployer(Request $request)
{
    // Validate input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'company_name' => 'required|string|max:255',
    ]);

    try {
        DB::transaction(function () use ($request) {
            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make(Str::random(12)), // Temporary password
                'user_type' => 'employer',
            ]);

            // Generate a unique token
            $token = Str::uuid();

            // Create employer entry
            $employer = Employer::create([
                'user_id' => $user->id,
                'company_name' => $request->company_name,
                'status' => 'pending',
                'verification_token' => $token,
            ]);

            // Send email with verification link
            Mail::to($user->email)->send(new EmployerRegistrationMail($user, $token));
        });

        return redirect()->back()->with('success', 'Employer registration email sent successfully.');
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Failed to register employer. Please try again.']);
    }
}





public function completeRegistration(Request $request, $token)
{
    Log::info("🔥 Complete Registration triggered for token: " . $token);

    $employer = Employer::where('verification_token', $token)->first();

    if (!$employer) {
        Log::error("❌ Employer NOT found for token: " . $token);
        return redirect()->route('employer.dashboard')->with('error', 'Employer not found.');
    }

    Log::info("✅ Employer found: " . $employer->id);

    // Validate input
    try {
        $validated = $request->validate([
            'business_number' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:15',
            'company_address' => 'required|string|max:255',
        ]);
        Log::info("✅ Validation passed");
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error("❌ Validation failed: " . json_encode($e->errors()));
        return back()->withErrors($e->errors())->withInput();
    }

    // Update employer details
    try {
        $employer->update([
            'business_number' => $validated['business_number'],
            'contact_phone' => $validated['contact_phone'],
            'company_address' => $validated['company_address'],
            'status' => 'registered',
            'verification_token' => null, // Remove token after successful registration
        ]);

        Log::info("🎉 Employer updated successfully: " . $employer->id);

        return redirect()->route('login')->with('success', '🎉 Thank you for completing your registration! You can now log in.');
    } catch (\Exception $e) {
        Log::error("❌ Error updating employer: " . $e->getMessage());
        return back()->withErrors(['error' => 'Failed to complete registration.']);
    }
}









}   

