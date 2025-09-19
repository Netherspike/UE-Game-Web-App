<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ItemTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $fillable = [
        'type',
        'name',
        'value',
        'display_name',
        'description',
        'thumbnail_path',
        'static_mesh_path',
        'general',
        'stats',
        'attributes',
        'abilities',
        'additional_data',
    ];

    protected function casts(): array
    {
        return [
            'type' => ItemTypeEnum::class,
            'general' => 'array',
            'stats' => 'array',
            'attributes' => 'array',
            'abilities' => 'array',
            'additional_data' => 'array',
        ];
    }

    protected $attributes = [
        'general' => '{}',
        'stats' => '{}',
        'attributes' => '{}',
        'abilities' => '{}',
        'additional_data' => '{}',
    ];

}
