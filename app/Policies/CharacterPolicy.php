<?php

namespace App\Policies;

use App\Models\Character;
use App\Models\User;

class CharacterPolicy
{
    public function access(User $user, Character $character): bool
    {
        return $user->id === $character->user_id || $user->is_admin;
    }
}
