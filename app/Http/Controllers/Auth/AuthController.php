<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'username' => 'required|max:16|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ], [
            'username.required' => 'Username harus diisi.',
            'username.max' => 'Username maksimal hanya 16 karakter.',
            'username.unique' => 'Username sudah dipakai.',
            'email.required' => 'email harus diisi.',
            'email.email' => 'Format email harus benar.',
            'email.unique' => 'Email sudah dipakai.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password salah.'
        ]);

        $user = User::create($fields);

        return response()->json([
            'message' => 'Akun berhasil dibuat.',
            'user' => $user
        ], 201);
    }
}
