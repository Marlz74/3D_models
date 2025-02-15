<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [UserController::class, 'profile']);
});




Route::fallback(function () {
    return response()->json(['message' => 'Endpoint not found!'], 404);
}); 
