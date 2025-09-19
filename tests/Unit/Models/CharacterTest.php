<?php

use App\Models\Character;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->character = Character::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Test Character',
        'gender' => 'Male',
        'class' => 'Warrior'
    ]);
});

describe('Character Model', function () {
    test('belongs to a user', function () {
        expect($this->character->user)
            ->toBeInstanceOf(User::class)
            ->and($this->character->user->id)->toBe($this->user->id);
    });

    test('has correct default json attributes', function () {
        $newCharacter = Character::factory()->create([
            'user_id' => $this->user->id
        ]);

        expect($newCharacter)
            ->general->toBe([])
            ->inventory->toBe([])
            ->stats->toBe([])
            ->equipment->toBe([])
            ->skills->toBe([])
            ->attributes->toBe([])
            ->abilities->toBe([])
            ->quests->toBe([])
            ->additional_data->toBe([])
            ->materials->toBe([]);
    });

    test('can be filled with valid attributes', function () {
        $data = [
            'name' => 'New Character',
            'gender' => 'Female',
            'class' => 'Mage',
            'user_id' => $this->user->id
        ];

        $character = Character::create($data);

        expect($character)
            ->name->toBe('New Character')
            ->gender->toBe('Female')
            ->class->toBe('Mage')
            ->user_id->toBe($this->user->id);
    });

    test('json fields cant be updated', function () {
        $this->character->stats = ['health' => 100];
        $this->character->save();

        $this->character->refresh();

        expect($this->character->stats)
            ->toBe(['health' => 100]);
    });
});
