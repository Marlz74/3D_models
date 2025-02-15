<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);




Route::fallback(function () {
    return response()->json(['message' => 'Endpoint not found!'], 404);
}); 
