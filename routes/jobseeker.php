<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Jobseeker\DashboardController;
use App\Http\Controllers\Jobseeker\JobApplicationController;
use App\Http\Controllers\Jobseeker\SurveyController;

Route::middleware(['auth', 'checkUserType:jobseeker'])->prefix('jobseeker')->group(function () {
    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('jobseeker.dashboard');
    Route::get('/manage-profile', [DashboardController::class, 'manageProfile'])->name('jobseeker.manageProfile');
    Route::get('/view-applications', [DashboardController::class, 'viewApplications'])->name('jobseeker.viewApplications');
    Route::get('/view-listings', [DashboardController::class, 'viewListings'])->name('jobseeker.viewListings');
    Route::get('/notifications', [DashboardController::class, 'notifications'])->name('jobseeker.notifications');
    Route::get('/edit-profile', [DashboardController::class, 'editProfile'])->name('jobseeker.editProfile');
    Route::get('/save-jobs', [DashboardController::class, 'saveJobs'])->name('jobseeker.saveJobs');
    
    // Job Applications Routes
    Route::get('/applications', [JobApplicationController::class, 'index'])->name('jobseeker.applications.index');
    Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])->name('jobseeker.applications.store');
    Route::get('/applications/{application}', [JobApplicationController::class, 'show'])->name('jobseeker.applications.show');
    Route::delete('/applications/{application}', [JobApplicationController::class, 'destroy'])->name('jobseeker.applications.destroy');
    
    // Survey Routes
    Route::get('/survey', [SurveyController::class, 'index'])->name('jobseeker.survey.index');
    Route::get('/survey/{survey}', [SurveyController::class, 'show'])->name('jobseeker.survey.show');
    Route::post('/survey/{survey}', [SurveyController::class, 'store'])->name('jobseeker.survey.store');
    Route::get('/survey/results', [SurveyController::class, 'results'])->name('jobseeker.survey.results');
}); 