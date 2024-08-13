<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        if ($request->user('sanctum')) {
            return response()->json([
                'status' => 'error',
                'message' => 'User already logged in',
            ], 401);
        }

        $user = User::create($request->validated());

        return response()->json([
            'message' => 'User registered successfully',
            'data' => $user,
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        if ($request->user('sanctum')) {
            return response()->json([
                'status' => 'error',
                'message' => 'User already logged in',
            ], 401);
        }

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid login credentials',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'User logged in successfully',
            'data' => [
                'token' => $token,
                'admin' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'phone' => $user->phone,
                    'email' => $user->email,
                ],
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User logged out successfully',
        ]);
    }
}
