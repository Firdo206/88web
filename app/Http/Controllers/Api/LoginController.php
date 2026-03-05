<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email','password');

        if(Auth::attempt($credentials)){
            $user = Auth::user();

            return response()->json([
                "status" => true,
                "message" => "Login berhasil",
                "data" => $user
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "Email atau password salah"
        ],401);
    }
}