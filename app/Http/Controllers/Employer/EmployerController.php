<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class EmployerController extends Controller
{
    public function showRegistrationForm()
    {
        return view('employer.register.employer_register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'company_name' => ['required', 'string', 'max:255'],
            'company_description' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'employer',
        ]);

        $user->company()->create([
            'name' => $request->company_name,
            'description' => $request->company_description,
        ]);

        Auth::login($user);

        return redirect()->route('employer.dashboard');
    }

    public function dashboard()
    {
        $company = auth()->user()->company;
        $jobs = $company->jobs;
        return view('employer.dashboard.index', compact('company', 'jobs'));
    }
} 