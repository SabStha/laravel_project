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
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:255',
            'company_phone' => 'required|string|max:20',
        ]);

        try{
        // Use DB transaction to ensure data integrity
        DB::transaction(function() use ($validated) {
            // Create the user in the users table
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'user_type' => 'employer', // Set user type to 'employer'
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
        } catch (Exception $e) {
            // If something goes wrong, redirect back with error
            return back()->withInput()
                        ->withErrors(['error' => '登録に失敗しました。もう一度お試しください。']);
        }
    }

    public function dashboard()
    {
            return view('employer_dashboard'); // Ensure you have this Blade view
    }

    public function showCompleteRegistration()
{
    $employer = auth()->user()->employer;

    if (!$employer) {
        return redirect()->route('employer.dashboard')->with('error', 'Employer profile not found.');
    }

    $businessCategories = BusinessCategory::all();
    $tasks = Task::all();

    return view('complete-registration', compact('employer', 'businessCategories', 'tasks'));
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

    return view('employers.edit-registration', compact('user', 'businessCategories', 'tasks'));
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







}   

