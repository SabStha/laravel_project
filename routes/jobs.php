<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shared\JobController;

Route::middleware(['auth'])->group(function () {
    // Public Job Routes
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');
    
    // Job Application Routes
    Route::post('/jobs/{job}/apply', [JobController::class, 'apply'])->name('jobs.apply');
}); 