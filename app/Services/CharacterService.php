<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Character;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class CharacterService
{
    /**
     * @return LengthAwarePaginator
     */
    public function getPaginatedCharacters(string $search = null): LengthAwarePaginator
    {
        $query = Character::query();

        if (!empty($search)) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        return $query->paginate(config('pagination.per_page', 10));
    }

    public function getAllCharacters(): Collection
    {
        return Character::all();
    }

    /**
     * Create a new character for a specific user.
     *
     * @param  array  $data
     * @return Character
     */
    public function createCharacter(array $data): Character
    {
        return Character::query()->create($data);
    }

    /**
     * Update an existing character.
     *
     * @param  Character  $character
     * @param  array  $data
     * @return bool
     */
    public function updateCharacter(Character $character, array $data): bool
    {
        return $character->update($data);
    }

    /**
     * Delete the given character.
     *
     * @param  Character  $character
     * @return bool|null
     */
    public function deleteCharacter(Character $character): ?bool
    {
        return $character->delete();
    }

    /**
     * TODO: move this to gate/policy
     * Ensure the given character belongs to the authenticated user.
     *
     * @param  Character  $character
     * @return void
     */
    public function authorizeCharacter(Character $character): void
    {
        $user = Auth::user();
        if ($character->user_id !== $user->id && !$user->is_admin) {
            abort(403, 'Unauthorized action.');
        }
    }
}
