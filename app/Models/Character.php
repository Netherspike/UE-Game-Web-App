<?php

declare(strict_types=1);

namespace App\Models;

use App\Policies\CharacterPolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[UsePolicy(CharacterPolicy::class)]
class Character extends Model
{
    use HasFactory;

    protected $table = 'characters';

    protected $fillable = [
        'name',
        'gender',
        'class',
        'user_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * Casting JSON fields ensures their values are handled as arrays.
     */
    protected function casts(): array
    {
        return [
            'general' => 'array',
            'inventory' => 'array',
            'stats' => 'array',
            'equipment' => 'array',
            'skills' => 'array',
            'attributes' => 'array',
            'abilities' => 'array',
            'quests' => 'array',
            'additional_data' => 'array',
            'materials' => 'array',
        ];
    }

    /**
     * The model's default values for attributes.
     *
     * Defaults for all JSON fields are set to empty JSON objects (or arrays).
     */
    protected $attributes = [
        'general' => '{}',
        'inventory' => '{}',
        'stats' => '{}',
        'equipment' => '{}',
        'skills' => '{}',
        'attributes' => '{}',
        'abilities' => '{}',
        'quests' => '{}',
        'additional_data' => '{}',
        'materials' => '{}',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
