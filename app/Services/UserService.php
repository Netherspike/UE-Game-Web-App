<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function updateUser(User $user, array $data): ?User
    {
        $user->update($data);
        $user->refresh();
        return $user;
    }

    public function deleteUser(User $user): true
    {
        $user->delete();
        return true;
    }

    public function getPaginatedUsers(?string $search = null): LengthAwarePaginator
    {
        $query = User::query();

        if (!empty($search)) {
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%');
        }

        return $query->orderBy('id', 'desc')
            ->paginate(config('pagination.per_page', 10));
    }
}
