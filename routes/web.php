<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobSeekerController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\OperatorController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Job Seeker Registration Routes
Route::get('/register/jobseeker', [JobSeekerController::class, 'showRegistrationForm']);
Route::post('/register/jobseeker', [JobSeekerController::class, 'register']);

// Employer Registration Routes
Route::get('/register/employer', [EmployerController::class, 'showRegistrationForm']);
Route::post('/register/employer', [EmployerController::class, 'register']);

// Operator Registration Routes
Route::get('/register/operator', [OperatorController::class, 'showRegistrationForm']);
Route::post('/register/operator', [OperatorController::class, 'register']);
