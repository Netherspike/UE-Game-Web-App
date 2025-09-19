<?php

declare(strict_types=1);

namespace App\Actions\Item;

use App\Dtos\ItemDto;
use App\Models\Item;

class UpdateItemAction
{
    public function handle(Item $item, ItemDto $itemDto): Item
    {
        $item->update(
            array_filter($itemDto->toArray())
        );
        $item->refresh();
        return $item;
    }
}
