<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChatbotController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/message', [ChatbotController::class, 'storeMessage']);
Route::get('/messages/{phone}', [ChatbotController::class, 'getMessages']);
Route::post('/conversations/{phone}/update', [ChatbotController::class, 'updateConversation']);
Route::get('/conversations/{phone}/status', [ChatbotController::class, 'getStatus']);

