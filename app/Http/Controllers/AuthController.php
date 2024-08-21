<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//to do: criar request
class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->all();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response('Autenticação realizada com sucesso');
        }

        return response("As credencias não batem com nossos registros.", 401);
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
