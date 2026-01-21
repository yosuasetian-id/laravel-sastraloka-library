<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Gate;

class ProfileController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum');
    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Profile::all();
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        return $profile;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request, Profile $profile)
    {
        $fields = $request->validated();

        $profile->update($fields);

        return response()->json([
            'message' => 'Profile berhasil diperbarui.',
            'data' => $profile
        ]);
    }
}
