<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ModelFileController;

Route::post('/upload', [ModelFileController::class, 'upload']); 

Route::get('/list', [ModelFileController::class, 'list']);

Route::delete('/delete/{id}', [ModelFileController::class, 'delete']);

Route::put('/update/{id}', [ModelFileController::class, 'update']);



Route::get('/',function(){
    return response()->json(['message'=>'Invalid API endpoint.'],200);
});

Route::fallback(function () {
    return response()->json(['message' => 'Endpoint not found!'], 404);
}); 
