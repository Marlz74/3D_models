<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|max:55',
                'email' => 'email|required|unique:users',
                'password' => 'required|confirmed',
            ]);

            $validatedData['password'] = Hash::make($validatedData['password']);

            $user = User::create($validatedData);

            $accessToken = $user->createToken('authToken', ['*'], now()->addMinutes(60))->plainTextToken;

            return response()->json(['user' => $user, 'access_token' => $accessToken], 201);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error: ' . $th->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $loginData = $request->validate([
                'email' => 'email|required',
                'password' => 'required',
            ]);

            if (!auth()->attempt($loginData)) {
                return response()->json(['message' => 'Invalid credentials!'], 401);
            }

            $accessToken = auth()->user()->createToken('authToken', ['*'], now()->addMinutes(60))->plainTextToken;

            return response()->json(['user' => auth()->user(), 'access_token' => $accessToken], 200);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error: ' . $th->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json(['message' => 'Logged out successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error: ' . $th->getMessage()], 500);
        }
    }
}
