<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function authenticated(Request $request, $user)
    {
        // Check the user type and redirect accordingly
        if ($user->user_type == 'employer') {
            return redirect()->route('employer.dashboard'); // Redirect to employer dashboard
        } elseif ($user->user_type == 'jobseeker') {
            return redirect()->route('jobseeker.dashboard'); // Redirect to jobseeker dashboard
        } else {
            return redirect()->route('operator.dashboard'); // Default fallback, you can change this
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to home or login page after logout
        return redirect('/');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    // LoginController.php

}
