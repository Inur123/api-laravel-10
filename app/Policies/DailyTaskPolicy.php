<?php

namespace App\Policies;

use App\Models\User;

class DailyTaskPolicy
{
    /**
     * Create a new policy instance.
     */
    public function create(User $user)
    {
        return $user->role === 'admin';
    }
}
