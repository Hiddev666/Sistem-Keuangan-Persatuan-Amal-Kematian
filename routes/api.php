<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\MidtransCallbackController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

// routes/api.php
Route::post('/midtrans/webhook', [MidtransCallbackController::class, 'handle']);
