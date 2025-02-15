<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller\HasMiddleware;
use Illuminate\Routing\Controller\Middleware;

class UserController extends Controller
{

    public function middleware()
    {
        // new Middleware();
        return ['auth:sanctum'];
    }
    public function profile()
    {
        try {

            $user=  Auth::user();
            if(!$user){
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            return response()->json(['user' => auth()->user()], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
