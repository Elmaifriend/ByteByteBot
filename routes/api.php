<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChatbotController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/message', [ChatbotController::class, 'storeMessage']);
Route::get('/messages/{phone}', [ChatbotController::class, 'getMessages']);
Route::post('/conversations/{phone}/update', [ChatbotController::class, 'updateConversation']);
Route::get('/conversations/{phone}/status', [ChatbotController::class, 'getStatus']);
