<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Gate;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Profile::with('user')->get();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Profile::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request, $id)
    {
        $profile = Profile::findOrFail($id);

        if (! Gate::allows('update-profile', $profile)) {
            abort(403, 'Unauthorized');
        }

        $fields = $request->validated();

        $profile->update($fields);

        return response()->json([
            'message' => 'Profile updated',
            'data' => $profile
        ]);
    }
}
