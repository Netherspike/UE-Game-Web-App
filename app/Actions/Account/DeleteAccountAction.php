<?php

declare(strict_types=1);

namespace App\Actions\Account;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DeleteAccountAction
{
    public function handle(User $user): bool
    {
        if (Auth::id() === $user->id) {
            Auth::logout();
        }

        return $user->deleteOrFail();
    }
}
