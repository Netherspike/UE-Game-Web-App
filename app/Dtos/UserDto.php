<?php

declare(strict_types=1);

namespace App\Dtos;

use Spatie\LaravelData\Data;

class UserDto extends Data
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $email = null,
        public readonly ?string $currentPassword = null,
        public readonly ?string $password = null
    ) {}
}
