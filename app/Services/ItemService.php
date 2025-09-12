<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

class ItemService
{
    /**
     * Create a new Item in the database.
     *
     * @param array $data
     * @throws QueryException
     * @return Item
     */
    public function createItem(array $data): Item
    {
        return Item::query()->create($data);
    }

    /**
     * Retrieve all Items from the database.
     *
     * @return Collection
     */
    public function getAllItems(): Collection
    {
        return Item::all();
    }

    /**
     * Update an existing Item by its ID.
     *
     * @param Item $item
     * @param array $data
     * @return Item
     * @throws \Throwable
     */
    public function updateItem(Item $item, array $data): Item
    {
        $item->update($data);
        $item->refresh();
        return $item;
    }

    /**
     * Delete an Item by its ID.
     *
     * @param Item $item
     * @return bool
     * @throws \Throwable
     */
    public function deleteItem(Item $item): void
    {
        $item->delete();
    }

    /**
     * Retrieve a paginated collection of Items.
     *
     * @param string|null $search
     * @return LengthAwarePaginator
     */
    public function getPaginatedItems(string $search = null): LengthAwarePaginator
    {
        $query = Item::query();

        if ($search) {
            $query->where('display_name', 'LIKE', '%' . $search . '%');
        }

        return $query->paginate(config('pagination.per_page', 10));
    }
}
