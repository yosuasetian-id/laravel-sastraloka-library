<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])->name('verification.verify');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/email/resend', [AuthController::class, 'resend']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/user/delete/request', [AuthController::class, 'deleteAccount']);
    Route::get('/user/delete/confirm/{id}/{hash}', [AuthController::class, 'confirmDeleteAccount'])
        ->name('user.delete.confirm');
});

Route::apiResource('profile', ProfileController::class);
