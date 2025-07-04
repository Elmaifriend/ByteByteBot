<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChatbotController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/api/message', [ChatbotController::class, 'storeMessage']);
Route::get('/api/messages/{phone}', [ChatbotController::class, 'getMessages']);
Route::post('/api/conversations/{phone}/update', [ChatbotController::class, 'updateConversation']);
Route::get('/api/conversations/{phone}/status', [ChatbotController::class, 'getStatus']);
