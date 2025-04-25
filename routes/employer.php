<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employer\DashboardController;
use App\Http\Controllers\Employer\JobController;
use App\Http\Controllers\Employer\CompanyController;
use App\Http\Controllers\Employer\JobApplicationController;

Route::middleware(['auth', 'checkUserType:employer'])->prefix('employer')->group(function () {
    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('employer.dashboard');
    
    // Job Routes
    Route::get('/jobs', [JobController::class, 'index'])->name('employer.jobs.index');
    Route::get('/jobs/create', [JobController::class, 'create'])->name('employer.jobs.create');
    Route::post('/jobs', [JobController::class, 'store'])->name('employer.jobs.store');
    Route::get('/jobs/{job}', [JobController::class, 'show'])->name('employer.jobs.show');
    Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->name('employer.jobs.edit');
    Route::put('/jobs/{job}', [JobController::class, 'update'])->name('employer.jobs.update');
    Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->name('employer.jobs.destroy');
    
    // Company Routes
    Route::get('/company/edit', [CompanyController::class, 'edit'])->name('employer.company.edit');
    Route::put('/company', [CompanyController::class, 'update'])->name('employer.company.update');
    
    // Job Applications Routes
    Route::get('/applications', [JobApplicationController::class, 'index'])->name('employer.applications.index');
    Route::get('/applications/{application}', [JobApplicationController::class, 'show'])->name('employer.applications.show');
    Route::put('/applications/{application}/status', [JobApplicationController::class, 'updateStatus'])->name('employer.applications.updateStatus');
}); 