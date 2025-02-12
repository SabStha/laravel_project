<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\Evaluation;  // Add this line to import the Evaluation model


class OperatorRegisterController extends Controller
{
    use RegistersUsers;

    // Set the redirection after successful registration
    protected $redirectTo = '/operator/dashboard';  // Redirect to operator dashboard

    // Validate the registration data
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    // Create the new operator user
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type' => 'operator', // Ensure the user type is 'operator'
        ]);
    }

    // Show the registration form
    public function showRegistrationForm()
    {
        return view('auth.operator_register');  // Render the operator registration view
    }
}
