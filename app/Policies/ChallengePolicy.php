<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Challenge;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChallengePolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->role === 'admin';
    }
}

