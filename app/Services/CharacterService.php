<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Character;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
}
