<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Validasi input menggunakan Validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'code_register' => 'string|nullable',
        ]);

        $role = 'user';
        if ($request->input('registration_code') === env('REGISTRATION_CODE')) {
            $role = 'admin';
        }
        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Buat user baru
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'role' => $role,
                'password' => bcrypt($request->input('password')),
            ]);
            // Respon sukses
            return response()->json([
                'status' => true,
                'message' => 'User registered successfully',
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            // Tangani error yang tidak terduga
            return response()->json([
                'status' => false,
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|string|'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ]);
        }

        $is_login = Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ]);

        $is_admin =  Auth::user()->role === 'admin';

        if ($is_login && $is_admin) {
            $token = $request->user()->createToken('authToken')->plainTextToken;
            return response()->json([
                'status' => true,
                'message' => 'Admin logged in successfully',
                'data' => Auth::user(),
                'token' => $token,
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'User logged in successfully',
                'data' => Auth::user()
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'email or password is wrong',
        ]);
    }


    public function logout(Request $request)
    {
        $user = $request->get('authenticated_user');
        if (!$user->tokens()->delete()) {
            return response()->json([
                'status' => false,
                'message' => 'Logout failed'
            ], 500);
        }
        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully'
        ], 200);
    }
}
