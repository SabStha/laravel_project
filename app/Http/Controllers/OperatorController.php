<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluation;  // Add this line to import the Evaluation modeluse App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\Jobseeker;
use App\Models\EvaluationAxis;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



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
        return view('dashboard');
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

    public function viewJobseekers(Request $request)
    {
        Log::info('View Jobseekers - Request Parameters', $request->all());

        // Log raw queries being executed
        DB::listen(function ($query) {
            Log::info('SQL Query', ['sql' => $query->sql, 'bindings' => $query->bindings]);
        });

        $graduationDates = Jobseeker::whereNotNull('expected_to_graduate')
            ->selectRaw("DATE_FORMAT(expected_to_graduate, '%Y-%m') as grad_month")
            ->distinct()
            ->orderBy('grad_month', 'desc')
            ->pluck('grad_month');

        $schools = Jobseeker::whereNotNull('school')->distinct()->pluck('school');
        $citizenships = Jobseeker::whereNotNull('citizenship')->distinct()->pluck('citizenship');
        $jlptLevels = Jobseeker::whereNotNull('jlpt')->distinct()->pluck('jlpt');
        $wages = Jobseeker::whereNotNull('wage')->distinct()->pluck('wage')->sort();

        $query = Jobseeker::with('user');

        // Filtering logic
        if ($request->filled('name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->name . '%');
            });
        }

        if ($request->filled('email')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('email', 'LIKE', '%' . $request->email . '%');
            });
        }

        if ($request->filled('school')) {
            $query->where('school', $request->school);
        }

        if ($request->filled('citizenship')) {
            $query->where('citizenship', $request->citizenship);
        }

        if ($request->filled('jlpt')) {
            $query->where('jlpt', $request->jlpt);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('graduation_date')) {
            $query->whereRaw("DATE_FORMAT(expected_to_graduate, '%Y-%m') = ?", [$request->graduation_date]);
        }

        if ($request->filled('age')) {
            $query->whereNotNull('birthday')
                ->whereRaw('TIMESTAMPDIFF(YEAR, birthday, CURDATE()) >= ?', [$request->age]);
        }

        if ($request->filled('parttimejob')) {
            $query->where('parttimejob', $request->parttimejob);
        }

        if ($request->filled('wage')) {
            $query->whereNotNull('wage')
                ->where('wage', '>=', $request->wage);
        }

        $jobseekers = $query->paginate(100);

        // Log final query before execution
        Log::info('Final Jobseekers Query', ['query' => $query->toSql(), 'bindings' => $query->getBindings()]);

        if ($request->ajax()) {
            return view('jobseeker_grid_partial', compact('jobseekers'))->render();
        }

        return view('jobseeker_grid', compact('jobseekers', 'schools', 'citizenships', 'jlptLevels', 'wages', 'graduationDates'));
    }

        



        public function submitEvaluation(Request $request, $user_id)
        {
            $request->validate([
                'ratings' => 'required|array',
                'ratings.*' => 'integer|min:1|max:5'
            ]);

            // 🔍 Fetch correct `jobseeker_id` using `user_id`
            $jobseeker = DB::table('jobseekers')->where('user_id', $user_id)->first();

            if (!$jobseeker) {
                return redirect()->back()->with('error', 'Jobseeker not found.');
            }

            // Store evaluations for each axis
            foreach ($request->input('ratings') as $axis_id => $rating) {
                DB::table('t_jobseeker_evaluations')->updateOrInsert(
                    [
                        'jobseeker_id' => $jobseeker->id, // Use correct `id`
                        'evaluation_axis_id' => $axis_id,
                    ],
                    [
                        'rating' => $rating,
                        'updated_at' => now(),
                    ]
                );
            }

            // ✅ Update jobseeker's `evaluation` field to 1
            DB::table('jobseekers')
                ->where('id', $jobseeker->id)
                ->update(['evaluation' => 1, 'updated_at' => now()]);

            return redirect()->route('operator.viewEvaluations')->with('status', 'Evaluation submitted successfully.');
        }



    



    public function evaluate($user_id)
    {
        // Find the jobseeker using user_id, not id
        $jobseeker = Jobseeker::where('user_id', $user_id)->firstOrFail();

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








    public function viewSurveyResults()
    {
        $jobseekers = DB::table('jobseekers')
            ->leftJoin('users', 'jobseekers.user_id', '=', 'users.id')
            ->select('jobseekers.id', 'users.name', 'users.email', 'jobseekers.total_score', 'jobseekers.survey_completed')
            ->orderByDesc('jobseekers.total_score')
            ->get();

        return view('survey_results', compact('jobseekers'));
    }

    public function viewJobseekerSurvey($jobseeker_id)
    {
        $jobseeker = DB::table('jobseekers')
            ->leftJoin('users', 'jobseekers.user_id', '=', 'users.id')
            ->where('jobseekers.id', $jobseeker_id)
            ->select('jobseekers.*', 'users.name', 'users.email')
            ->first();

        $survey_responses = DB::table('jobseeker_survey')
            ->leftJoin('surveys', 'jobseeker_survey.survey_id', '=', 'surveys.id')
            ->where('jobseeker_survey.jobseeker_id', $jobseeker_id)
            ->select('surveys.question_text', 'jobseeker_survey.selected_option', 'jobseeker_survey.score')
            ->get();

        return view('survey_detail', compact('jobseeker', 'survey_responses'));
    }







}