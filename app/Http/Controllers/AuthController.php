<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {
        $request->validated($request->all());

        if(!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['wrong credentials'],401);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('token')->plainTextToken
        ]);
    }

    public function register(RegisterRequest $request) {
        $request->validated($request->all());

        $user = User::create([
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        return response()->json([
            'user'  => $user,
            'token' => $user->createToken('token')->plainTextToken
        ],201);
    }

    public function logut() {
        dd("Login controller");
    }
}
