<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        $token = $user->createToken($user->username)->plainTextToken;

        $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Akun berhasil dibuat. Silahkan cek email untuk vertifikasi akun.',
            'user' => $user,
            'access_token' => $token
        ], 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'username' => 'required|exists:users,username',
            'password' => 'required'
        ], [
            'username.required' => 'Username harus diisi.',
            'username.exists' => 'Username tidak terdaftar.',
            'password.required' => 'Password harus diisi.'
        ]);

        $user = User::where('username', $fields['username'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json([
                'message' => 'Silahkan masukan data yang benar.'
            ], 401);
        }

        $user->tokens()->delete();

        $token = $user->createToken($user->username)->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil.',
            'access_token' => $token,
            'user' => $user
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Berhasil keluar.'
        ], 200);
    }

    public function verify(Request $request, $id, $hash)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Email tidak valid atau sudah kedaluwarsa.');
        }

        $user = User::findOrFail($id);

        if (! hash_equals(sha1($user->email), $hash)) {
            abort(403, 'Hash tidak valid.');
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return response()->json([
            'message' => 'Email berhsil divertifikasi.'
        ]);
    }

    // public function resend(Request $request)
    // {
    //     if ($request->user()->hasVerifiedEmail()) {
    //         return response()->json([
    //             'message' => 'Akun Anda sudah tervertifikasi.'
    //         ], 400);
    //     }

    //     $request->user()->sendEmailVerificationNotification();

    //     return response()->json([
    //         'message' => 'Link dikirim.'
    //     ]);
    // }
}
