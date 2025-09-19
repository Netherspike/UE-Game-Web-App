<?php

use App\Models\Character;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['is_admin' => true]);
    $this->regularUser = User::factory()->create(['is_admin' => false]);
    $this->character = Character::factory()->create([
        'name' => 'Test Character',
        'user_id' => $this->regularUser->id
    ]);
});

describe('character management', function () {
    test('non-admin cannot access character management', function () {
        $response = $this->actingAs($this->regularUser)
            ->get(route('characters.index'));

        $response->assertRedirect();
    });

    test('admin can view characters list', function () {
        $response = $this->actingAs($this->admin)
            ->get(route('characters.index'));

        $response->assertOk()
            ->assertViewIs('management.characters.index')
            ->assertViewHas('characters')
            ->assertSee('Test Character');
    });

    test('admin can view character details', function () {
        $response = $this->actingAs($this->admin)
            ->get(route('characters.show', $this->character));

        $response->assertOk()
            ->assertViewIs('management.characters.show')
            ->assertViewHas('character')
            ->assertSee($this->character->name);
    });

    test('admin can update character', function () {
        $response = $this->actingAs($this->admin)
            ->put(route('characters.update', $this->character), [
                'name' => 'Updated Character',
            ]);

        $response->assertRedirect(route('characters.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('characters', [
            'id' => $this->character->id,
            'name' => 'Updated Character',
        ]);
    });

    test('admin can delete character', function () {
        $response = $this->actingAs($this->admin)
            ->delete(route('characters.destroy', $this->character));

        $response->assertRedirect(route('characters.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('characters', [
            'id' => $this->character->id,
        ]);
    });

    test('validates required fields when updating character', function () {
        $response = $this->actingAs($this->admin)
            ->put(route('characters.update', $this->character), [
                'name' => '',
            ]);

        $response->assertSessionHasErrors(['name']);
    });
});
