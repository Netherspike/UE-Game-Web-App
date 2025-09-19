<?php

declare(strict_types=1);

namespace App\Actions\Account;

use App\Dtos\UserDto;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAccountAction
{
    public function handle(UserDto $userDto): User
    {
        $user = User::query()->make([
            'name' => $userDto->name,
            'email' => $userDto->email,
        ]);

        $user->password = Hash::make($userDto->password);
        $user->save();

        return $user;
    }
}
