<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        try {
            return response()->json(['user' => auth()->user()], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
