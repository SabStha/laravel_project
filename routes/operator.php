<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Operator\DashboardController;
use App\Http\Controllers\Operator\JobseekerController;
use App\Http\Controllers\Operator\SurveyController;
use App\Http\Controllers\Operator\SurveyResponseController;

Route::middleware(['auth', 'checkUserType:operator'])->prefix('operator')->group(function () {
    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('operator.dashboard');
    Route::get('/listings', [DashboardController::class, 'listings'])->name('operator.listings');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('operator.profile');
    Route::get('/applications', [DashboardController::class, 'applications'])->name('operator.applications');
    Route::get('/notifications', [DashboardController::class, 'notifications'])->name('operator.notifications');
    
    // Jobseeker Management Routes
    Route::get('/jobseekers', [JobseekerController::class, 'index'])->name('operator.jobseekers.index');
    Route::get('/jobseekers/{jobseeker}', [JobseekerController::class, 'show'])->name('operator.jobseekers.show');
    Route::get('/jobseekers/{jobseeker}/evaluate', [JobseekerController::class, 'evaluate'])->name('operator.jobseekers.evaluate');
    Route::post('/jobseekers/{jobseeker}/evaluate', [JobseekerController::class, 'submitEvaluation'])->name('operator.jobseekers.submitEvaluation');
    
    // Survey Routes
    Route::get('/survey-results', [SurveyController::class, 'index'])->name('operator.survey-results.index');
    Route::get('/survey-results/{jobseeker}', [SurveyController::class, 'show'])->name('operator.survey-results.show');
    
    // Survey Response Routes
    Route::get('/survey-responses', [SurveyResponseController::class, 'index'])->name('operator.survey-responses.index');
    Route::get('/survey-responses/{response}', [SurveyResponseController::class, 'show'])->name('operator.survey-responses.show');
    Route::get('/survey-responses/{response}/edit', [SurveyResponseController::class, 'edit'])->name('operator.survey-responses.edit');
    Route::put('/survey-responses/{response}', [SurveyResponseController::class, 'update'])->name('operator.survey-responses.update');
}); 