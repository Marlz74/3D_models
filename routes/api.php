<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModelFileController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});


Route::post('/upload', [ModelFileController::class, 'upload']); 

Route::get('/list', [ModelFileController::class, 'list']);

Route::delete('/delete/{id}', [ModelFileController::class, 'delete']);

Route::put('/update/{id}', [ModelFileController::class, 'update']);



Route::fallback(function () {
    return response()->json(['message' => 'Endpoint not found!'], 404);
}); 
