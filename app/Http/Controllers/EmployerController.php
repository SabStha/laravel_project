<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class EmployerController extends Controller
{
   
    public function showRegistrationForm()
    {
        return view('auth.employer_register');
    }

  
    public function register(Request $request)
    {
   
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

       
        $user = User::create([

            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'employer', 

        ]);

        $userId = $user->id;


        Auth::login($user);

        
         return redirect('/dashboard')->with('success', '登録が完了しました, User ID: ' . $userId);
   
    }
}
