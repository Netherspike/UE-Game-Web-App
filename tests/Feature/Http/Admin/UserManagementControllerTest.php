<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['is_admin' => true]);
    $this->regularUser = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'is_admin' => false
    ]);
});

describe('user management', function () {
    test('non-admin cannot access user management', function () {
        $response = $this->actingAs($this->regularUser)
            ->get(route('users.index'));

        $response->assertRedirect();
    });

    test('admin can view users list', function () {
        $response = $this->actingAs($this->admin)
            ->get(route('users.index'));

        $response->assertOk()
            ->assertViewIs('management.users.index')
            ->assertViewHas('users')
            ->assertSee('Test User');
    });

    test('admin can create new user', function () {
        $response = $this->actingAs($this->admin)
            ->post(route('users.store'), [
                'name' => 'New User',
                'email' => 'new@example.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ]);

        $response->assertRedirect(route('users.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'name' => 'New User',
            'email' => 'new@example.com'
        ]);
    });

    test('admin can view user details', function () {
        $response = $this->actingAs($this->admin)
            ->get(route('users.show', $this->regularUser));

        $response->assertOk()
            ->assertViewIs('management.users.show')
            ->assertViewHas('user')
            ->assertSee($this->regularUser->email);
    });

    test('admin can update user', function () {
        $response = $this->actingAs($this->admin)
            ->put(route('users.update', $this->regularUser), [
                'name' => 'Updated Name',
                'email' => 'updated@example.com'
            ]);

        $response->assertRedirect(route('users.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $this->regularUser->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com'
        ]);
    });

    test('admin can delete user', function () {
        $response = $this->actingAs($this->admin)
            ->delete(route('users.destroy', $this->regularUser));

        $response->assertRedirect(route('users.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('users', [
            'id' => $this->regularUser->id
        ]);
    });

    test('validates required fields when creating user', function () {
        $response = $this->actingAs($this->admin)
            ->post(route('users.store'), [
                'name' => '',
                'email' => 'not-an-email',
                'password' => 'short'
            ]);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
    });

    test('prevents admin from deleting themselves', function () {
        $this->actingAs($this->admin)
            ->delete(route('users.destroy', $this->admin));

        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    });

    test('admin can delete another admin', function () {
        $anotherAdmin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($this->admin)
            ->delete(route('users.destroy', $anotherAdmin));

        $response->assertRedirect(route('users.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('users', ['id' => $anotherAdmin->id]);
    });
});
