<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobseekerController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\JobApplicationController;


// Home route
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes


// ... previous code remains the same
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// use App\Http\Controllers\EmployerController;
// use App\Http\Controllers\OperatorController;
// use App\Http\Controllers\DashboardController;
// use App\Http\Controllers\JobseekerController;


// Employer Routes
Route::get('/register/employer', [EmployerController::class, 'showRegistrationForm']);
Route::post('/register/employer', [EmployerController::class, 'register'])->name('employer.register');
Route::get('/employer/dashboard', [DashboardController::class, 'employerDashboard'])->middleware('checkUserType:employer')->name('employer.dashboard');

// Jobseeker Routes
Route::get('/register/jobseeker', [JobseekerController::class, 'showRegistrationForm'])->name('jobseeker.register');
Route::post('/register/jobseeker', [JobseekerController::class, 'register']);
Route::middleware(['auth', 'checkUserType:jobseeker', 'ensure.survey.completed'])->group(function () {
    Route::get('/jobseeker/dashboard', [DashboardController::class, 'jobseekerDashboard'])->name('jobseeker.dashboard');
    Route::get('/manage-profile', [JobseekerController::class, 'manageProfile'])->name('jobseeker.manageProfile');
    Route::get('/view-applications', [JobseekerController::class, 'viewApplications'])->name('jobseeker.viewApplications');
});
//how Survey Form (For Jobseekers)
Route::get('jobseeker/survey', [SurveyController::class, 'showSurvey'])
    ->middleware('auth') // Ensure only logged-in users can access
    ->name('survey.show');

// Submit Survey Responses (Jobseeker Submits Answers)
Route::post('jobseeker/survey/submit', [SurveyController::class, 'submitSurvey'])
    ->middleware('auth') // Prevents unauthenticated users from submitting
    ->name('survey.submit');

// Admin View to See Responses (For Admin Users)
Route::get('/operator/survey-responses', [SurveyController::class, 'viewResponses'])
    ->middleware(['auth', 'operator']) // Optional: Restrict to Admin Users
    ->name('survey.responses');

Route::get('/view-listings', [JobseekerController::class, 'viewListings'])->name('jobseeker.viewListings');
Route::get('/view-applications', [JobseekerController::class, 'viewApplications'])->name('jobseeker.viewApplications');
Route::get('/manage-profile', [JobseekerController::class, 'manageProfile'])->name('jobseeker.manageProfile');
Route::get('/notifications', [JobseekerController::class, 'notifications'])->name('jobseeker.notifications');
Route::get('/edit-profile', [JobseekerController::class, 'editProfile'])->name('jobseeker.editProfile');
Route::get('/save-jobs', [JobseekerController::class, 'saveJobs'])->name('jobseeker.saveJobs');

Route::post('/operator/jobseeker/{user_id}/evaluate', [OperatorController::class, 'submitEvaluation'])
        ->name('operator.submitEvaluation');
Route::get('/operator/jobseeker/{user_id}/evaluate', [OperatorController::class, 'evaluate'])
        ->name('operator.evaluate');

// Operator Routes

Route::middleware('guest')->group(function () {
    Route::get('/register/operator', [OperatorController::class, 'showRegistrationForm'])->name('operator.register');
    Route::post('/register/operator', [OperatorController::class, 'register']);
});

Route::middleware(['auth', 'operator'])->prefix('operator')->group(function () {
    Route::get('/dashboard', [OperatorController::class, 'dashboard'])->name('operator.dashboard');
    Route::get('/listings', [OperatorController::class, 'viewListings'])->name('operator.viewListings');
    Route::get('/profile', [OperatorController::class, 'manageProfile'])->name('operator.manageProfile');
    //Route::get('/evaluations', [OperatorController::class, 'viewEvaluations'])->name('operator.viewEvaluations');
    Route::get('/applications', [OperatorController::class, 'viewApplications'])->name('operator.viewApplications');
    Route::get('/notifications', [OperatorController::class, 'notifications'])->name('operator.notifications');
    Route::get('/evaluations', [OperatorController::class, 'viewEvaluations'])->name('operator.viewEvaluations');
    
    Route::get('/operator/jobseeker/{user_id}/edit-evaluation', [OperatorController::class, 'editEvaluation'])->name('operator.editEvaluation');
    Route::get('/survey-results', [OperatorController::class, 'viewSurveyResults'])->name('operator.surveyResults');
    Route::get('/survey-results/{jobseeker_id}', [OperatorController::class, 'viewJobseekerSurvey'])->name('operator.surveyDetail');

    Route::get('/jobseekers', [OperatorController::class, 'viewJobseekers'])->name('operator.viewJobseekers');


    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('operator.logout');
});



Route::get('/jobseekers', [JobSeekerController::class, 'index'])->name('jobseekers.index');
Route::get('/jobseekers/{id}', [JobseekerController::class, 'show'])->name('jobseekers.show');




// //Create,Update and Delete for Job
// Route::get('/jobs',[Jobcontroller::class, 'search']);
// Route::get('/jobs/{id}',[Jobcontroller::class,'view']);
// Route::get('/company/jobs/create',[CompanyController::class,'create']);
// Route::post('/company/jobs/create',[CompanyController::class,'create']);
// Route::get('/company/jobs/{id}/edit',[CompanyController::class,'edit']);
// Route::post('/company/jobs/{id}/update',[CompanyController::class,'update']);
// Route::get('/company/jobs/{id}/delete',[CompanyController::class,'delete']);

// //Password reset and update
// Route::get('/password/reset',[PasswordController::class,'reset']);
// Route::get('/password/reset/sent',[PasswordController::class,'sent']);
// Route::get('/password/reset/{token}',[PasswordController::class,'edit']);
// Route::post('/password/reset/{token}',[PasswordController::class,'update']);


// Operator Routes
Route::middleware(['auth', 'operator'])->prefix('operator')->group(function () {
    Route::get('/dashboard', [OperatorController::class, 'dashboard'])->name('operator.dashboard');
    Route::get('/listings', [OperatorController::class, 'viewListings'])->name('operator.viewListings');
    Route::get('/profile', [OperatorController::class, 'manageProfile'])->name('operator.manageProfile');
    // Route::get('/evaluations', [OperatorController::class, 'viewEvaluations'])->name('operator.viewEvaluations');
    Route::get('/applications', [OperatorController::class, 'viewApplications'])->name('operator.viewApplications');
    Route::get('/notifications', [OperatorController::class, 'notifications'])->name('operator.notifications');
    Route::get('/evaluations', [OperatorController::class, 'viewEvaluations'])->name('operator.viewEvaluations');
    Route::get('/unratedJobSeekers', [OperatorController::class, 'viewUnratedJobSeekers'])->name('operator.viewUnratedJobSeekers');
}); // ✅ FIXED: Changed `);` to `}`
//Edit ,Update
Route::get('/profile/jobseeker/{user_id}',[JobseekerController::class,'profile']);
Route::get('/profile/jobseeker/{user_id}',[JobseekerController::class,'edit_profile']);
Route::post('/profile/jobseeker/{user_id}',[JobseekerController::class,'update_profile']);

Route::get('/profile/employer/{user_id}',[EmployerController::class,'profile']);
Route::get('/profile/employer/{user_id}',[EmployerController::class,'edit_profile']);
Route::post('/profile/employer/{user_id}',[EmployerController::class,'update_profile']);

// Route::get('/jobs/{job_id}/apply',[Jobcontroller::class,'apply']);
// Route::post('/jobs/{job_id}/apply',[Jobcontroller::class,'create']);




// Correct password reset routes

Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm']);
// Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
// Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm']);
// Route::post('/password/reset', [ResetPasswordController::class, 'reset']);

// Route::get('/help',[HelpController::class,'help']);

// Route::get('/contact',[ContactController::class,'contactForm']);
// Route::get('/about',[ContactController::class,'about']);
// Route::get('/terms',[ContactController::class,'terms']);

Route::get('/contact',[ContactController::class,'contactForm']);
Route::get('/about',[ContactController::class,'about']);
Route::get('/terms',[ContactController::class,'terms']);

// Route::get('/jobview', function() {
//     return view('jobformview');
// });


Route::middleware(['auth', 'ensure.employer.registered'])->group(function () {
    Route::get('/jobs', [JobController::class, 'create'])->name('jobs_create');


    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/jobsview', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show'); // ✅ Add this line

    Route::get('/jobs/{id}/edit', [JobController::class, 'edit'])->name('jobs.edit'); // ✅ Add this line
    Route::put('/jobs/{id}', [JobController::class, 'update'])->name('jobs.update'); // ✅ Add update route
    Route::delete('/jobs/{id}', [JobController::class, 'destroy'])->name('jobs.destroy');
});



Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.form');
Route::post('/contact', [ContactController::class, 'handleForm'])->name('contact.submit');



Route::get('/contacts', [ContactController::class, 'index'])->name('contacts');


Route::get('/about', [CompanyController::class, 'showCompanyInfo'])->name('about');

use App\Http\Controllers\TermsController;

Route::get('/terms', [TermsController::class, 'index'])->name('terms');
Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/messages/{conversationId}', [ChatController::class, 'getMessages']);
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);
    Route::delete('/chat/delete/{conversationId}', [ChatController::class, 'deleteConversation']);
    Route::get('/chat/start/{id}', [ChatController::class, 'start'])->name('chat.start');
}); 

Route::middleware(['auth'])->group(function () {

    // Route::get('/employer/complete-registration/{token}', [EmployerController::class, 'showCompleteRegistration'])
    // ->name('employer.completeRegistrationForm');





    // Route::get('/employer/complete-registration', [EmployerController::class, 'showCompleteRegistration'])
    //     ->name('employer.completeRegistrationForm');

    // Route::post('/employer/complete-registration', [EmployerController::class, 'storeCompleteRegistration'])
    //     ->name('employer.completeRegistration');

    Route::get('/employer/edit-registration', [EmployerController::class, 'edit'])->name('employer.editRegistrationForm');
    Route::post('/employer/update-registration', [EmployerController::class, 'update'])->name('employer.updateRegistration');


});

// Employer clicks email link
Route::get('/employer/complete-registration/{token}', [EmployerController::class, 'showCompleteRegistrationForm'])
->name('employer.completeRegistrationForm');

// Employer submits registration
Route::post('/employer/complete-registration/{token}', [EmployerController::class, 'completeRegistration'])->name('employer.completeRegistration');




// Route to display employer registration form (GET)
Route::get('/admin/employer/register', [EmployerController::class, 'showRegistrationForm'])
    ->name('admin.registerEmployerForm');



// Admin registers employer & sends email

Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'applyForJob'])->middleware('auth');



Route::get('/view-listings', [JobseekerController::class, 'viewListings'])
    ->name('jobseeker.viewListings')
    ->middleware('auth');

