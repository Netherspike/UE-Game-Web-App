<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ItemService
{
    public function getAllItems(): Collection
    {
        return Item::all();
    }

    public function getPaginatedItems(string|null $search): LengthAwarePaginator
    {
        $query = Item::query();

        $query->when($search, function($query, $search): void {
            $query->where('display_name', 'LIKE', $search . '%');
        });

        return $query->paginate(config('pagination.per_page', 10));
    }
}
