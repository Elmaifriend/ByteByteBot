<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChatbotController;

Route::get('/', function () {
    return view('welcome');
});


