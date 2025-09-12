<?php
declare(strict_types=1);

namespace App\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

readonly class AccountService
{
    public function getUserCharacters(): array|Collection
    {
        return Auth::user()?->characters ?? [];
    }

    public function getAuthenticatedUser(): Authenticatable
    {
        return Auth::user();
    }

    public function updateAccountDetails(array $data): Authenticatable
    {
        $user = Auth::user();
        $user->update($data);
        $user->refresh();
        return $user;
    }

    public function updatePassword(string $currentPassword, string $newPassword): bool
    {
        $user = Auth::user();

        // Verify current password
        if (!Hash::check($currentPassword, $user->password)) {
            return false;
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        return true;
    }

    public function deleteAccount(): void
    {
        Auth::user()->delete();
        Auth::logout();
    }
}
