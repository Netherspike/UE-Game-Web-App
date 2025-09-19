<?php

declare(strict_types=1);

namespace App\Policies;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AccountPolicy
{
    public function access(User $user): bool
    {
        return $user->id === Auth::id() || $user->is_admin;
    }
}
