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

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Employer Routes
Route::middleware('guest')->group(function () {
    Route::get('/register/employer', [EmployerController::class, 'showRegistrationForm'])->name('employer.register');
    Route::post('/register/employer', [EmployerController::class, 'register']);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// Employer Routes
Route::get('/register/employer', [EmployerController::class, 'showRegistrationForm']);
Route::post('/register/employer', [EmployerController::class, 'register'])->name('employer.register');
Route::get('/employer/dashboard', [DashboardController::class, 'employerDashboard'])->middleware('checkUserType:employer')->name('employer.dashboard');

// Jobseeker Routes
Route::get('/register/jobseeker', [JobseekerController::class, 'showRegistrationForm'])->name('jobseeker.register');
Route::post('/register/jobseeker', [JobseekerController::class, 'register']);
Route::get('/jobseeker/dashboard', [DashboardController::class, 'jobseekerDashboard'])->middleware('checkUserType:jobseeker')->name('jobseeker.dashboard');

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
Route::middleware(['auth', 'operator'])->prefix('operator')->group(function () {
    Route::get('/dashboard', [OperatorController::class, 'dashboard'])->name('operator.dashboard');
    Route::get('/listings', [OperatorController::class, 'viewListings'])->name('operator.viewListings');
    Route::get('/profile', [OperatorController::class, 'manageProfile'])->name('operator.manageProfile');
    //Route::get('/evaluations', [OperatorController::class, 'viewEvaluations'])->name('operator.viewEvaluations');
    Route::get('/applications', [OperatorController::class, 'viewApplications'])->name('operator.viewApplications');
    Route::get('/notifications', [OperatorController::class, 'notifications'])->name('operator.notifications');
    Route::get('/evaluations', [OperatorController::class, 'viewEvaluations'])->name('operator.viewEvaluations');
    
    Route::get('/operator/jobseeker/{user_id}/edit-evaluation', [OperatorController::class, 'editEvaluation'])->name('operator.editEvaluation');

    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('operator.logout');
});


//Create,Update and Delete for Job
Route::get('/jobs',[Jobcontroller::class, 'search']);
Route::get('/jobs/{id}',[Jobcontroller::class,'view']);
Route::get('/company/jobs/create',[CompanyController::class,'create']);
Route::post('/company/jobs/create',[CompanyController::class,'create']);
Route::get('/company/jobs/{id}/edit',[CompanyController::class,'edit']);
Route::post('/company/jobs/{id}/update',[CompanyController::class,'update']);
Route::get('/company/jobs/{id}/delete',[CompanyController::class,'delete']);

//Password reset and update
Route::get('/password/reset',[PasswordController::class,'reset']);
Route::get('/password/reset/sent',[PasswordController::class,'sent']);
Route::get('/password/reset/{token}',[PasswordController::class,'edit']);
Route::post('/password/reset/{token}',[PasswordController::class,'update']);


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

Route::get('/jobs/{job_id}/apply',[Jobcontroller::class,'apply']);
Route::post('/jobs/{job_id}/apply',[Jobcontroller::class,'create']);


// Correct password reset routes

Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm']);
// Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
// Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm']);
// Route::post('/password/reset', [ResetPasswordController::class, 'reset']);

Route::get('/help',[HelpController::class,'help']);

Route::get('/contact',[ContactController::class,'contactForm']);
Route::get('/about',[ContactController::class,'about']);
Route::get('/terms',[ContactController::class,'terms']);
