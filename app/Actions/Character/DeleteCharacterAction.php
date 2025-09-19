<?php

declare(strict_types=1);

namespace App\Actions\Character;
use App\Models\Character;

class DeleteCharacterAction
{
    public function handle(Character $character): void
    {
        $character->delete();
    }
}
