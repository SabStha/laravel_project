<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('jobseeker-register', [JobseekerController::class, 'showRegistrationForm'])->name('jobseeker.register');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use App\Http\Controllers\EmployerController;

Route::get('/register/employer', [EmployerController::class, 'showRegistrationForm']);
Route::post('/register/employer', [EmployerController::class, 'employer.register'])->name('employer.register');
Route::get('/employer/dashboard',[EmployerController::class,'dashboard'])->name('employer.dashboard');

use App\Http\Controllers\JobseekerController;

// Jobseeker Routes
// Route::get('/jobseeker/register', [App\Http\Controllers\JobseekerController::class, 'showRegistrationForm'])->name('jobseeker.register');
// Route::post('/jobseeker/register', [App\Http\Controllers\JobseekerController::class, 'register']);

//User Registeration
Route::get('/register/jobseeker', [JobseekerController::class, 'showRegistrationForm'])->name('jobseeker.register');
Route::post('/register/jobseeker', [JobseekerController::class, 'register']);
Route::get('/jobseeker/dashboard', [JobseekerController::class, 'dashboard'])->name('jobseeker.dashboard');


use App\Http\Controllers\OperatorController;
//Operator Registeration
Route::get('/register/operator', [OperatorController::class, 'showRegistrationForm']);
Route::post('/register/operator', [OperatorController::class, 'register']);

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

//Dashboard for User,Employer and Operator
Route::get('/dashboard/jobseeker',[DashboardController::class,'jobseekerDashboard']);
Route::get('/dashboard/employer',[DashboardController::class,'employerDashboard']);
Route::get('/dashboard/operator',[DashboardController::class,'operatorDashboard']);

//
Route::get('/operator/jobseeker',[OperatorController::class,'checkjobseeker']);
Route::get('/operator/jobseeker/{user_id}/evaluate',[OperatorController::class,'evaluate']);
Route::post('/operator/jobseeker/{user_id}/evaluate',[OperatorController::class,'update']);

//Edit ,Update
Route::get('/profile/jobseeker/{user_id}',[JobseekerController::class,'profile']);
Route::get('/profile/jobseeker/{user_id}',[JobseekerController::class,'edit_profile']);
Route::post('/profile/jobseeker/{user_id}',[JobseekerController::class,'update_profile']);

Route::get('/profile/employer/{user_id}',[EmployerController::class,'profile']);
Route::get('/profile/employer/{user_id}',[EmployerController::class,'edit_profile']);
Route::post('/profile/employer/{user_id}',[EmployerController::class,'update_profile']);

Route::get('/jobs/{job_id}/apply',[Jobcontroller::class,'apply']);
Route::post('/jobs/{job_id}/apply',[Jobcontroller::class,'create']);

Route::get('/employer/applicants',[EmployerController::class,'applicants']);
Route::get('/messages/jobseeker/{user_id}',[MessageController::class,'message_jobseeker']);
Route::post('/messages/jobseeker/{user_id}',[MessageController::class,'create_message']);
Route::get('/messages/employeer/{user_id}',[MessageController::class,'message_employeer']);
Route::get('/messages/employeer/{user_id}',[MessageController::class,'create_message']);

Route::get('/messages/jobseeker/{message_id',[MessageController::class,'message_view']);
Route::get('/messages/employeer/{message_id',[MessageController::class,'message_view']);

Route::get('/help',[HelpController::class,'help']);

Route::get('/contact',[ContactController::class,'contactForm']);
Route::get('/about',[ContactController::class,'about']);
Route::get('/terms',[ContactController::class,'terms']);

 // <-- Add this line

// Route::get('/operator/register', [App\Http\Controllers\Auth\OperatorRegisterController::class, 'showRegistrationForm'])
//     ->name('operator.register.form');
// Route::post('/operator/register', [App\Http\Controllers\Auth\OperatorRegisterController::class, 'register'])
//     ->name('operator.register');
// Route::get('/operator/dashboard', [OperatorController::class, 'dashboard']) // Now Laravel knows where to find the class
//     ->name('dashboard');


// Route::get('/employer/register', [App\Http\Controllers\EmployerController::class, 'showRegistrationForm'])->name('employer.register');
// Route::post('/employer/register', [App\Http\Controllers\EmployerController::class, 'register']);
// Route::get('/employer/dashboard', [App\Http\Controllers\EmployerController::class, 'dashboard'])->name('employer.dashboard');
