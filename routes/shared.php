<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shared\HomeController;
use App\Http\Controllers\Shared\TermsController;

// Home Routes
Route::get('/', [HomeController::class, 'welcome'])->name('welcome');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Terms and Conditions
Route::get('/terms', [TermsController::class, 'index'])->name('terms'); 