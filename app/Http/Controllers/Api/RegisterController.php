<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {

        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|min:6"
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
             'phone' => $request->phone,
            "role" => "user", // default role
            "password" => Hash::make($request->password)
        ]);

        return response()->json([
            "status" => true,
            "message" => "Register berhasil",
            "data" => $user
        ]);
    }
}