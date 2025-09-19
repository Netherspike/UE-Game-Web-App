<?php

namespace Tests\Unit\Actions\Character;

use App\Actions\Character\UpdateCharacterAction;
use App\Dtos\CharacterDto;
use App\Models\Character;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->character = Character::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Original Name',
    ]);
    $this->action = app(UpdateCharacterAction::class);
});

describe('update character action tests', function () {
    test('can update character attributes', function () {
        $characterDto = new CharacterDto(
            name: 'Updated Name',
        );

        $this->action->handle($this->character, $characterDto);
        $this->character->refresh();

        expect($this->character)
            ->name->toBe('Updated Name');
    });

    test('can partially update character', function () {
        $originalHealth = $this->character->health;
        $characterDto = new CharacterDto(
            name: 'Partial Update'
        );

        $this->action->handle($this->character, $characterDto);
        $this->character->refresh();

        expect($this->character)
            ->name->toBe('Partial Update')
            ->health->toBe($originalHealth);
    });

    test('maintains user association after update', function () {
        $characterDto = new CharacterDto(
            name: 'Updated Name'
        );

        $this->action->handle($this->character, $characterDto);
        $this->character->refresh();

        expect($this->character->user_id)->toBe($this->user->id);
    });
});
