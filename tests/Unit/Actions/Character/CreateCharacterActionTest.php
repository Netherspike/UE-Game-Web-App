<?php

namespace Tests\Unit\Actions\Character;

use App\Actions\Character\CreateCharacterAction;
use App\Dtos\CharacterDto;
use App\Enums\CharacterClassEnum;
use App\Models\Character;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->action = app(CreateCharacterAction::class);
});

describe('create character action tests', function () {
    test('can create character', function () {
        $characterDto = new CharacterDto(
            name: 'Test Character',
            user_id: $this->user->id,
            gender: 'male',
            class: CharacterClassEnum::MAGE,
        );

        $this->action->handle($characterDto);

        $this->assertDatabaseHas('characters', [
            'name' => 'Test Character',
            'user_id' => $this->user->id,
        ]);
    });

    test('associates character with correct user', function () {
        $characterDto = new CharacterDto(
            name: 'Test Character',
            user_id: $this->user->id,
            gender: 'male',
            class: CharacterClassEnum::MAGE,
        );

        $this->action->handle($characterDto);

        $character = Character::where('name', 'Test Character')->first();
        expect($character->user)->toBeInstanceOf(User::class)
            ->and($character->user->id)->toBe($this->user->id);
    });
});
