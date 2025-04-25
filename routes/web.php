<?php

use Illuminate\Support\Facades\Route;

// Include all route files
require __DIR__.'/auth.php';
require __DIR__.'/shared.php';
require __DIR__.'/jobseeker.php';
require __DIR__.'/employer.php';
require __DIR__.'/operator.php';
require __DIR__.'/chat.php';
require __DIR__.'/jobs.php';
require __DIR__.'/contact.php';

// Home route
Route::get('/', function () {
    return view('welcome');
});

