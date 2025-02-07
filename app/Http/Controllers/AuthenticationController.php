<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'email'    => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials))
        {
            $token = Auth::user()->createToken('passportToken')->accessToken;
            return response()->json([
                'user' => Auth::user(),
                'token' => $token
            ], 200);
        }

        return response()->json([
            'error' => 'Unauthorised'
        ], 401);

    }

    public function refreshToken(Request $request)
    {
        $request->validate([
            'refresh_token' => 'required|string'
        ]);

        $refreshToken = $request->refresh_token;

        $newToken = Auth::guard('api')->refresh();

        if (!$newToken) {
            return response()->json([
                'error' => 'Unauthenticated'
            ], 401);
        }

        return response()->json([
            'token' => $newToken
        ], 200);
    }
}
