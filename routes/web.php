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

Route::middleware(['auth'])->prefix('employer')->group(function () {
    Route::get('/dashboard', [EmployerController::class, 'dashboard'])->name('employer.dashboard');
    Route::get('/create-listing', [EmployerController::class, 'createListing'])->name('employer.createListing');
    Route::get('/view-listings', [EmployerController::class, 'viewListings'])->name('employer.viewListings');
    Route::get('/view-applications', [EmployerController::class, 'viewApplications'])->name('employer.viewApplications');
    Route::get('/manage-profile', [EmployerController::class, 'manageProfile'])->name('employer.manageProfile');
    Route::get('/notifications', [EmployerController::class, 'notifications'])->name('employer.notifications');
    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('employer.logout');
});

// Jobseeker Routes
Route::middleware('guest')->group(function () {
    Route::get('/register/jobseeker', [JobseekerController::class, 'showRegistrationForm'])->name('jobseeker.register');
    Route::post('/register/jobseeker', [JobseekerController::class, 'register']);
});

Route::middleware(['auth'])->prefix('jobseeker')->group(function () {
    Route::get('/dashboard', [JobseekerController::class, 'dashboard'])->name('jobseeker.dashboard');
    Route::get('/view-listings', [JobseekerController::class, 'viewListings'])->name('jobseeker.viewListings');
    Route::get('/view-applications', [JobseekerController::class, 'viewApplications'])->name('jobseeker.viewApplications');
    Route::get('/manage-profile', [JobseekerController::class, 'manageProfile'])->name('jobseeker.manageProfile');
    Route::get('/notifications', [JobseekerController::class, 'notifications'])->name('jobseeker.notifications');
    Route::get('/edit-profile', [JobseekerController::class, 'editProfile'])->name('jobseeker.editProfile');
    Route::get('/save-jobs', [JobseekerController::class, 'saveJobs'])->name('jobseeker.saveJobs');

    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('jobseeker.logout');
});


// Operator Routes
Route::middleware('guest')->group(function () {
    Route::get('/register/operator', [OperatorController::class, 'showRegistrationForm'])->name('operator.register');
    Route::post('/register/operator', [OperatorController::class, 'register']);
});


Route::middleware(['auth', 'operator'])->group(function () {
    Route::get('/operator/jobseeker/{user_id}/evaluate', [OperatorController::class, 'evaluate'])
        ->name('operator.evaluate');
    Route::post('/operator/jobseeker/{user_id}/evaluate', [OperatorController::class, 'submitEvaluation']);

    Route::post('/operator/jobseeker/{user_id}/evaluate', [OperatorController::class, 'submitEvaluation'])
        ->name('operator.submitEvaluation');

    Route::get('/operator/jobseeker/{user_id}/evaluate', [OperatorController::class, 'evaluate'])
        ->name('operator.evaluate');
    
        Route::get('/operator/jobseeker/{user_id}/edit-evaluation', 
        [OperatorController::class, 'editEvaluation']
    )->name('operator.editEvaluation');
       
});


// Operator Routes
Route::middleware(['auth', 'operator'])->prefix('operator')->group(function () {
    Route::get('/dashboard', [OperatorController::class, 'dashboard'])->name('operator.dashboard');
    Route::get('/listings', [OperatorController::class, 'viewListings'])->name('operator.viewListings');
    Route::get('/profile', [OperatorController::class, 'manageProfile'])->name('operator.manageProfile');
    //Route::get('/evaluations', [OperatorController::class, 'viewEvaluations'])->name('operator.viewEvaluations');
    Route::get('/applications', [OperatorController::class, 'viewApplications'])->name('operator.viewApplications');
    Route::get('/notifications', [OperatorController::class, 'notifications'])->name('operator.notifications');
    Route::get('/evaluations', [OperatorController::class, 'viewEvaluations'])->name('operator.viewEvaluations');


    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('operator.logout');
});

// Job Management Routes
// Route::get('/jobs', [JobController::class, 'search']);
// Route::get('/jobs/{id}', [JobController::class, 'view']);
// Route::get('/company/jobs/create', [CompanyController::class, 'create']);
// Route::post('/company/jobs/create', [CompanyController::class, 'store']);
// Route::get('/company/jobs/{id}/edit', [CompanyController::class, 'edit']);
// Route::post('/company/jobs/{id}/update', [CompanyController::class, 'update']);
// Route::get('/company/jobs/{id}/delete', [CompanyController::class, 'delete']);

// Password Reset Routes
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Correct password reset routes
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm']);
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm']);
Route::post('/password/reset', [ResetPasswordController::class, 'reset']);

// Dashboard Routes
Route::get('/dashboard/jobseeker', [DashboardController::class, 'jobseekerDashboard']);
Route::get('/dashboard/employer', [DashboardController::class, 'employerDashboard']);
Route::get('/dashboard/operator', [DashboardController::class, 'operatorDashboard']);

// Messaging Routes
// Route::get('/messages/jobseeker/{user_id}', [MessageController::class, 'messageJobseeker']);
// Route::post('/messages/jobseeker/{user_id}', [MessageController::class, 'createMessage']);
// Route::get('/messages/employer/{user_id}', [MessageController::class, 'messageEmployer']);
// Route::post('/messages/employer/{user_id}', [MessageController::class, 'createMessage']);

// Miscellaneous Routes
// Route::get('/help', [HelpController::class, 'help']);
// Route::get('/contact', [ContactController::class, 'contactForm']);
// Route::get('/about', [ContactController::class, 'about']);
// Route::get('/terms', [ContactController::class, 'terms']);
