<?php

namespace Tests\Unit\Actions\Character;

use App\Actions\Character\DeleteCharacterAction;
use App\Models\Character;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->character = Character::factory()->create([
        'user_id' => $this->user->id
    ]);
    $this->action = app(DeleteCharacterAction::class);
});

describe('delete character action tests', function () {
    test('can delete character', function () {
        $this->action->handle($this->character);

        $this->assertDatabaseMissing('characters', [
            'id' => $this->character->id,
        ]);
    });

    test('admin can delete other user character', function () {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $otherUser = User::factory()->create();
        $otherCharacter = Character::factory()->create([
            'user_id' => $otherUser->id
        ]);

        $this->action->handle($otherCharacter);

        $this->assertDatabaseMissing('characters', [
            'id' => $otherCharacter->id,
        ]);
    });
});
