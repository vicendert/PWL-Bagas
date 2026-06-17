<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        if (Auth::attempt($request->only('username', 'password'))) {
            $user = Auth::user();
            if (!$user->is_active) {
                Auth::logout();
                return response()->json([
                    'success' => false,
                    'message' => 'Akun Anda dinonaktifkan.'
                ], 403);
            }

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'user' => $user
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Kredensial tidak valid'
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }
}
