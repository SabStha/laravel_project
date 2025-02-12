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
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobseekerController;


// Employer Routes
Route::get('/register/employer', [EmployerController::class, 'showRegistrationForm']);
Route::post('/register/employer', [EmployerController::class, 'register'])->name('employer.register');
Route::get('/employer/dashboard', [DashboardController::class, 'employerDashboard'])->middleware('checkUserType:employer')->name('employer.dashboard');

// Jobseeker Routes
Route::get('/register/jobseeker', [JobseekerController::class, 'showRegistrationForm'])->name('jobseeker.register');
Route::post('/register/jobseeker', [JobseekerController::class, 'register']);
Route::get('/jobseeker/dashboard', [DashboardController::class, 'jobseekerDashboard'])->middleware('checkUserType:jobseeker')->name('jobseeker.dashboard');

// Operator Routes
Route::get('/register/operator', [OperatorController::class, 'showRegistrationForm']);
Route::post('/register/operator', [OperatorController::class, 'register'])->name('operator.register');
Route::get('/operator/dashboard', [DashboardController::class, 'operatorDashboard'])->middleware('checkUserType:operator')->name('operator.dashboard');


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