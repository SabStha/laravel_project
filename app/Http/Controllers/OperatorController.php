<?php 

namespace App\Http\Controllers;

use App\Models\User; // Ensure you import the User model
use Illuminate\Http\Request;
use App\Models\Evaluation;  // Add this line to import the Evaluation modeluse App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\Jobseeker;
use App\Models\EvaluationAxis;
use Illuminate\Support\Facades\DB;



class OperatorController extends Controller

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


    public function dashboard()
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

    public function viewListings()
    {
        return view('operator.listings'); // Create the view for listings
    }

    public function manageProfile()
    {
        return view('operator.profile'); // Create the view for profile management
    }

    // public function viewEvaluations()
    // {
    //     // Fetch the evaluations for the logged-in operator
    //     $evaluations = Evaluation::where('operator_id', auth()->id())
    //                               ->orderBy('created_at', 'desc')
    //                               ->get();

    //     // Pass the evaluations to the view
    //     return view('evaluations', compact('evaluations'));
    // }

    public function viewEvaluations()
    {
        $jobseekers = DB::table('jobseekers')
            ->leftJoin('users', 'jobseekers.user_id', '=', 'users.id')
            ->select('jobseekers.*', 'users.name', 'users.email')
            ->get();

        // Fetch evaluation statuses
        foreach ($jobseekers as $jobseeker) {
            $jobseeker->isEvaluated = DB::table('t_jobseeker_evaluations')
                ->where('jobseeker_id', $jobseeker->id)
                ->exists();
        }

        return view('evaluations', compact('jobseekers'));
    }




    public function viewApplications()
    {
        return view('operator.applications'); // Create the view for applications
    }

    public function notifications()
    {
        return view('operator.notifications'); // Create the view for notifications
    }

    public function viewJobseekers()
    {
        // Fetch all jobseekers along with their evaluation status
        $jobseekers = User::where('user_type', 'jobseeker')
            ->with('evaluation') // Ensure this relationship exists in the User model
            ->get();

        // Pass the jobseekers to the view
        return view('evaluations', compact('jobseekers'));
    }

    public function submitEvaluation(Request $request, $user_id)
    {
        // ✅ Step 1: Validate input
        $request->validate([
            'ratings' => 'required|array|min:1',
            'ratings.*' => 'integer|min:1|max:5'
        ], [
            'ratings.required' => 'Please provide at least one rating.',
            'ratings.*.min' => 'Ratings must be at least 1.',
            'ratings.*.max' => 'Ratings cannot exceed 5.',
        ]);

        // ✅ Step 2: Fetch jobseeker using user_id
        $jobseeker = Jobseeker::where('user_id', $user_id)->first();

        if (!$jobseeker) {
            return redirect()->back()->with('error', 'Jobseeker not found.');
        }

        // ✅ Step 3: Store evaluations
        foreach ($request->input('ratings') as $axis_id => $rating) {
            DB::table('t_jobseeker_evaluations')->updateOrInsert(
                [
                    'jobseeker_id' => $jobseeker->id, // Use correct jobseeker ID
                    'evaluation_axis_id' => $axis_id,
                ],
                [
                    'rating' => $rating,
                    'updated_at' => now(),
                ]
            );
        }

        // ✅ Step 4: Show success message & redirect
        return redirect()->back()->with('success', 'Evaluation submitted successfully!');
    }




    



    public function evaluate($user_id)
    {
        // Find the user first (check if the user exists)
        $user = User::findOrFail($user_id);

        // Then find the corresponding jobseeker using the user's ID
        $jobseeker = Jobseeker::where('id', $user->id)->first();

        // If jobseeker is not found, return 404
        if (!$jobseeker) {
            abort(404, 'Job Seeker Not Found');
        }

        // Get all evaluation axes
        $evaluation_axes = DB::table('m_evaluation_axes')->get();

        // Fetch existing evaluations for the jobseeker
        $existingEvaluations = DB::table('t_jobseeker_evaluations')
            ->join('m_evaluation_axes', 't_jobseeker_evaluations.evaluation_axis_id', '=', 'm_evaluation_axes.id')
            ->where('t_jobseeker_evaluations.jobseeker_id', $jobseeker->id) // Use jobseeker.id instead of user_id
            ->select('m_evaluation_axes.name as axis_name', 't_jobseeker_evaluations.rating')
            ->get();

        return view('evaluate_form', compact('jobseeker', 'evaluation_axes', 'existingEvaluations'));
    }


    public function editEvaluation($user_id)
    {
        // Get jobseeker
        $jobseeker = Jobseeker::findOrFail($user_id);

        // Get all evaluation axes
        $evaluation_axes = DB::table('m_evaluation_axes')->get();

        // Fetch existing evaluations
        $existingEvaluations = DB::table('t_jobseeker_evaluations')
            ->join('m_evaluation_axes', 't_jobseeker_evaluations.evaluation_axis_id', '=', 'm_evaluation_axes.id')
            ->where('t_jobseeker_evaluations.jobseeker_id', $user_id)
            ->select('m_evaluation_axes.name as axis_name', 't_jobseeker_evaluations.rating')
            ->get();

        return view('evaluate_form', compact('jobseeker', 'evaluation_axes', 'existingEvaluations'));
    }

    





}
