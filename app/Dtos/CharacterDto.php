<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Enums\CharacterClassEnum;
use Spatie\LaravelData\Data;

class CharacterDto extends Data
{
    public function __construct(
        public ?string $name = null,
        public ?string $gender = null,
        public ?CharacterClassEnum $class = null,
        public ?int $user_id = null,
        public ?array $general = null,
        public ?array $inventory = null,
        public ?array $stats = null,
        public ?array $equipment = null,
        public ?array $skills = null,
        public ?array $attributes = null,
        public ?array $abilities = null,
        public ?array $quests = null,
        public ?array $additional_data = null,
    ) {}
}
