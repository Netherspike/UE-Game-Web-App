<?php

declare(strict_types=1);

namespace App\Actions\Item;

use App\Models\Item;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetItemsAction
{
    public function handle(?string $search = null): LengthAwarePaginator
    {
        $query = Item::query();

        $query->when($search, function($query, $search): void {
            $query->where('display_name', 'LIKE', $search . '%')
                ->orWhere('name', 'LIKE', $search . '%');
        });

        return $query->paginate(config('pagination.per_page', 10));
    }
}
