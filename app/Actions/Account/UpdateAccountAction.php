<?php

declare(strict_types=1);

namespace App\Actions\Account;

use App\Dtos\UserDto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdateAccountAction
{
    public function handle(UserDto $userDto): bool
    {
        $user = Auth::user();
        if ($userDto->password) {
            if (!Hash::check($userDto->currentPassword, $user->password)) {
                return false;
            }

            $user->password = Hash::make($userDto->password);
            $user->save();
        }

        $user->update([
            'name' => $userDto->name,
            'email' => $userDto->email
        ]);
        $user->refresh();

        return true;
    }
}
