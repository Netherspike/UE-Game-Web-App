<?php

declare(strict_types=1);

namespace App\Actions\Account;

use Illuminate\Support\Facades\Auth;

class DeleteAccountAction
{
    public function handle(): void
    {
        //Must logout first before deleting the account
        $user = Auth::user();
        Auth::logout();
        $user->deleteOrFail();
    }
}
