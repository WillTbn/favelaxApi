<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except(['login', 'register', 'unauthorized']);
    }
    public function unauthorized()
    {
        return response()->json(['error' => 'Não autenticado'],401);
    }
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);

        $token = $user->createToken('BearerToken')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    public function login(Request $request)
    {

        $loginData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($loginData)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        Auth::attempt($loginData);

        $user = Auth::user();
        $token = $user->createToken('BearerToken')->accessToken;

        return response()->json([
            'status' => 200,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ], 200);
    }

    public function logout()
    {
        if(Auth::guard('api')->check()){
            $user = auth('api')->user();
            $user->token()->revoke();

            return response()->json(['message' => 'Logged out successfully'], 200);
        }
        return response()->json(['message' =>  'unauthorized'], 401);
    }
}
