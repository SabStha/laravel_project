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
    Route::get('/profile', [JobseekerController::class, 'profile'])->name('jobseeker.profile');
    Route::get('/search', [JobseekerController::class, 'search'])->name('jobseeker.search');
    Route::get('/applications', [JobseekerController::class, 'applications'])->name('jobseeker.applications');
    Route::get('/saved-jobs', [JobseekerController::class, 'savedJobs'])->name('jobseeker.savedJobs');
    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('jobseeker.logout');
});

// Operator Routes
Route::middleware(['auth', 'operator'])->prefix('operator')->group(function () {
    Route::get('/dashboard', [OperatorController::class, 'dashboard'])->name('operator.dashboard');
    Route::get('/listings', [OperatorController::class, 'viewListings'])->name('operator.viewListings');
    Route::get('/profile', [OperatorController::class, 'manageProfile'])->name('operator.manageProfile');
});

//Password reset and update
Route::get('/password/reset',[PasswordController::class,'reset']);
Route::get('/password/reset/sent',[PasswordController::class,'sent']);
Route::get('/password/reset/{token}',[PasswordController::class,'edit']);
Route::post('/password/reset/{token}',[PasswordController::class,'update']);
