<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Enums\ItemTypeEnum;
use Spatie\LaravelData\Data;

class ItemDto extends Data
{
    public function __construct(
        public ?ItemTypeEnum $type = null,
        public ?string $name = null,
        public ?int $value = null,
        public ?string $display_name = null,
        public ?string $description = null,
        public ?string $thumbnail_path = null,
        public ?string $static_mesh_path = null,
        public ?array $general = null,
        public ?array $stats = null,
        public ?array $attributes = null,
        public ?array $abilities = null,
        public ?array $additional_data = null,
    ) {}
}
