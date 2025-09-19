<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

describe('account management', function () {
    test('guest cannot access account page', function () {
        $response = $this->get(route('account.show'));

        $response->assertRedirect(route('login'));
    });

    test('authenticated user can view account page', function () {
        $response = $this->actingAs($this->user)
            ->get(route('account.show'));

        $response->assertOk()
            ->assertViewIs('account.show')
            ->assertViewHas('user', $this->user);
    });

    test('authenticated user can view edit page', function () {
        $response = $this->actingAs($this->user)
            ->get(route('account.edit'));

        $response->assertOk()
            ->assertViewIs('account.edit')
            ->assertViewHas('user', $this->user);
    });

    test('authenticated user can update their account', function () {
        $response = $this->actingAs($this->user)
            ->put(route('account.update'), [
                'name' => 'Updated Name',
                'email' => 'updated@example.com',
            ]);

        $response->assertRedirect(route('account.show'));

        $this->user->refresh();
        expect($this->user->name)->toBe('Updated Name')
            ->and($this->user->email)->toBe('updated@example.com');
    });

    test('authenticated user can delete their account', function () {
        $response = $this->actingAs($this->user)
            ->delete(route('account.destroy'));

        $response->assertRedirect(route('home'));
        $this->assertDatabaseMissing('users', [
            'id' => $this->user->id
        ]);
    });

    test('update validates required fields', function () {
        $response = $this->actingAs($this->user)
            ->put(route('account.update'), [
                'name' => '',
                'email' => 'not-an-email',
            ]);

        $response->assertSessionHasErrors(['name', 'email']);
    });

    test('cannot update email to one that already exists', function () {
        $otherUser = User::factory()->create();

        $response = $this->actingAs($this->user)
            ->put(route('account.update'), [
                'name' => 'Valid Name',
                'email' => $otherUser->email,
            ]);

        $response->assertSessionHasErrors(['email']);
    });
});
