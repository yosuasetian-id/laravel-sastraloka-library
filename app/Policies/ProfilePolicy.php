<?php

namespace App\Policies;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProfilePolicy
{
    public function update(User $user, Profile $profile): Response
    {
        return $user->id === $profile->user_id ? Response::allow() : Response::deny('Anda bukan pemilik data.');
    }
}
