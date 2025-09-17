<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ItemService
{
    public function createItem(array $data): Item
    {
        return Item::query()->create($data);
    }

    public function getAllItems(): Collection
    {
        return Item::all();
    }

    public function updateItem(Item $item, array $data): Item
    {
        $item->update($data);
        $item->refresh();
        return $item;
    }

    public function deleteItem(Item $item): void
    {
        $item->delete();
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
