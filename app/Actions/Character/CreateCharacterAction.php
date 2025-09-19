<?php

declare(strict_types=1);

namespace App\Actions\Character;

use App\Dtos\CharacterDto;
use App\Models\Character;

class CreateCharacterAction
{
    public function handle(CharacterDto $characterDto): void
    {
        Character::query()->create($characterDto->toArray());
    }
}
