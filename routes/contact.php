<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shared\ContactController;

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/about', [ContactController::class, 'about'])->name('about'); 