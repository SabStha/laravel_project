<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shared\ChatController;

Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/messages/{conversationId}', [ChatController::class, 'getMessages']);
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);
    Route::delete('/chat/delete/{conversationId}', [ChatController::class, 'deleteConversation']);
    Route::get('/chat/start/{id}', [ChatController::class, 'start'])->name('chat.start');
}); 