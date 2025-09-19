<?php

declare(strict_types=1);

namespace App\Actions\Item;

use App\Dtos\ItemDto;
use App\Models\Item;

class CreateItemAction
{
    public function handle(ItemDto $itemDto): Item
    {
        return Item::query()->create(
            array_filter($itemDto->toArray())
        );
    }
}
