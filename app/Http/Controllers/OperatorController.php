<?php 

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Evaluation;
use App\Models\Jobseeker;
use App\Models\EvaluationAxis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\RegistersUsers;

class OperatorController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/operator/dashboard';

    public function __construct()
    {
        $this->middleware('auth')->except(['showRegistrationForm', 'register']);
        $this->middleware('operator')->except(['showRegistrationForm', 'register']);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type' => 'operator',
        ]);
    }

    public function showRegistrationForm()
    {
        return view('operator.register');
    }

    public function dashboard()
    {
        return view('operator.dashboard');
    }

    public function viewListings()
    {
        return view('operator.listings');
    }

    public function manageProfile()
    {
        return view('operator.profile');
    }

    public function evaluate($user_id)
    {
        $jobseeker = Jobseeker::with('user')->where('user_id', $user_id)->firstOrFail();
        $evaluationAxes = EvaluationAxis::all();
        
        return view('operator.evaluate', [
            'jobseeker' => $jobseeker,
            'evaluationAxes' => $evaluationAxes
        ]);
    }

    public function submitEvaluation(Request $request, $user_id)
    {
        $validated = $request->validate([
            'evaluation_axis_id' => 'required|exists:m_evaluation_axes,id',
            'score' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        try {
            DB::transaction(function() use ($validated, $user_id) {
                $evaluation = Evaluation::create([
                    'jobseeker_id' => $user_id,
                    'evaluation_axis_id' => $validated['evaluation_axis_id'],
                    'score' => $validated['score'],
                    'comment' => $validated['comment'] ?? null,
                    'evaluator_id' => Auth::id()
                ]);
            });

            return redirect()->back()->with('success', '評価が正常に保存されました。');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->withErrors(['error' => '評価の保存に失敗しました。もう一度お試しください。']);
        }
    }

    public function editEvaluation($user_id)
    {
        $jobseeker = Jobseeker::with(['user', 'evaluations'])->where('user_id', $user_id)->firstOrFail();
        $evaluationAxes = EvaluationAxis::all();
        
        return view('operator.edit_evaluation', [
            'jobseeker' => $jobseeker,
            'evaluationAxes' => $evaluationAxes
        ]);
    }

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
        return view('operator.applications'); 
    }

    public function notifications()
    {
        return view('operator.notifications'); 
    }

    public function viewJobseekers()
    {
        $jobseekers = User::where('user_type', 'jobseeker')
            ->with('evaluation') 
            ->get();

        return view('evaluations', compact('jobseekers'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'user_type' => 'operator', 
        ]);

        Auth::login($user);

        return redirect()->route('operator.dashboard');
    }
}
