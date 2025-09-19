<?php

use App\Enums\CharacterClassEnum;
use App\Models\Character;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->character = Character::factory()->create([
        'user_id' => $this->user->id,
        'name' => 'Test Character',
    ]);
});

describe('character management', function () {
    test('guest cannot access characters page', function () {
        $response = $this->get(route('mycharacters.index'));

        $response->assertRedirect(route('login'));
    });

    test('authenticated user can view their characters', function () {
        $response = $this->actingAs($this->user)
            ->get(route('mycharacters.index'));

        $response->assertOk()
            ->assertViewIs('characters.index')
            ->assertViewHas('characters')
            ->assertSee('Test Character');
    });

    test('authenticated user can create new character', function () {
        $response = $this->actingAs($this->user)
            ->post(route('mycharacters.store'), [
                'name' => 'New Character',
                'class' => CharacterClassEnum::WARRIOR->value,
                'gender' => 'male',
            ]);

        $response->assertRedirect(route('mycharacters.index'));
        $this->assertDatabaseHas('characters', [
            'name' => 'New Character',
            'user_id' => $this->user->id,
            'class' => CharacterClassEnum::WARRIOR,
            'gender' => 'male',
        ]);
    });

    test('authenticated user can view character details', function () {
        $response = $this->actingAs($this->user)
            ->get(route('mycharacters.show', $this->character));

        $response->assertOk()
            ->assertViewIs('characters.show')
            ->assertViewHas('character', $this->character);
    });

    test('authenticated user can update their character', function () {
        $response = $this->actingAs($this->user)
            ->put(route('mycharacters.update', $this->character), [
                'name' => 'Updated Character',
            ]);

        $response->assertRedirect(route('mycharacters.index'));
        $this->assertDatabaseHas('characters', [
            'id' => $this->character->id,
            'name' => 'Updated Character',
        ]);
    });

    test('authenticated user can delete their character', function () {
        $response = $this->actingAs($this->user)
            ->delete(route('mycharacters.destroy', $this->character));

        $response->assertRedirect(route('mycharacters.index'));
        $this->assertDatabaseMissing('characters', [
            'id' => $this->character->id,
        ]);
    });

    test('user cannot access other users characters', function () {
        $otherUser = User::factory()->create();
        $otherCharacter = Character::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('mycharacters.show', $otherCharacter));

        $response->assertForbidden();
    });

    test('validates character name on creation', function () {
        $response = $this->actingAs($this->user)
            ->post(route('mycharacters.store'), [
                'name' => '', // Empty name should fail validation
            ]);

        $response->assertSessionHasErrors(['name']);
    });

    test('validates unique character name per user', function () {
        $response = $this->actingAs($this->user)
            ->post(route('mycharacters.store'), [
                'name' => $this->character->name, // Duplicate name should fail
            ]);

        $response->assertSessionHasErrors(['name']);
    });
});
