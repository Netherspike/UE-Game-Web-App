<?php

declare(strict_types=1);

namespace App\Actions\Character;

use App\Models\Character;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetCharactersAction
{
    public function handle(?string $search = null): LengthAwarePaginator
    {
        $query = Character::query();

        $query->when($search, function($query, $search): void {
            $query->where('name', 'LIKE', $search . '%');
        });

        return $query->paginate(config('pagination.per_page', 10));
    }
}
