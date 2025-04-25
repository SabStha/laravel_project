<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\OperatorRegisterController;

// Authentication Routes
Auth::routes();

// Password Reset Routes
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Registration Routes
Route::middleware(['guest'])->group(function () {
    // Jobseeker Registration
    Route::get('/register/jobseeker', [RegisterController::class, 'showRegistrationForm'])->name('jobseeker.register');
    Route::post('/register/jobseeker', [RegisterController::class, 'register']);
    
    // Employer Registration
    Route::get('/register/employer', [RegisterController::class, 'showRegistrationForm'])->name('employer.register');
    Route::post('/register/employer', [RegisterController::class, 'register']);
    
    // Operator Registration
    Route::get('/register/operator', [OperatorRegisterController::class, 'showRegistrationForm'])->name('operator.register');
    Route::post('/register/operator', [OperatorRegisterController::class, 'register']);
}); 