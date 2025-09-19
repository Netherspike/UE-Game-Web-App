<?php

declare(strict_types=1);

namespace App\Actions\Item;

use App\Models\Item;

class DeleteItemAction
{
    public function handle(Item $item): void
    {
        $item->delete();
    }
}
