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
        // Redirect employers to their dashboard
        if ($user->user_type == 'employer') {
            return redirect()->route('employer.dashboard');
        }
        
        // Redirect jobseekers to survey if not completed
        elseif ($user->user_type == 'jobseeker') {
            if (!$user->jobseeker->survey_completed) {
                return redirect()->route('survey.show')->with('info', 'Please complete the survey before proceeding.');
            }
            return redirect()->route('jobseeker.dashboard');
        }
    
        // Default fallback for operators
        return redirect()->route('operator.dashboard');
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
