<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credential = Validator::make($request->all(), [
            "email" => "required",
            "password" => "required"
        ]);

        if ($credential->fails()) {
            return response()->json([
                "status" => "error",
                "error" => $credential->errors()
            ], 422);
        }

        if (!Auth::attempt($credential->validated())) {
            return response()->json([
                'status' => "error",
                'error' => 'Unauthorized'
            ], 401);
        }

        $user = Auth::user();
        if ($user instanceof User) {
            $token = $user->createToken("san-store")->plainTextToken;
            return response()->json([
                'status' => 'success',
                'token' => $token
            ], 200);
        }
    }
}
