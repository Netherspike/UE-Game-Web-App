<?php

declare(strict_types=1);

namespace App\Actions\Character;

use App\Dtos\CharacterDto;
use App\Models\Character;

class UpdateCharacterAction
{
    public function handle(Character $character, CharacterDto $characterDto): void
    {
        $character->update(
            array_filter($characterDto->toArray())
        );
    }
}
