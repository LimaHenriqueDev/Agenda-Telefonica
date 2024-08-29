<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return response(null, Response::HTTP_UNAUTHORIZED);
        }

        $request->session()->regenerate();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function isLoged()
    {
        return response()->json(null, 204);
    }

    public function logOut(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        $request->session()->invalidate();
        return response()->json(['message' => 'saiu com sucesso'], 200);
    }
}
