<?php

use App\Actions\Account\UpdateUserAction;
use App\Dtos\UserDto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function() {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

describe('Update user action tests', function() {
    test('can update authenticated user', function() {
        $userDto = new UserDto(
            name: fake()->name . '-SD',
            email: fake()->unique()->safeEmail()
        );

        $result = app(UpdateUserAction::class)->handle($userDto);

        expect($result)->toBeTrue();
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => $userDto->name,
            'email' => $userDto->email
        ]);
    });

    test('can update authenticated user with password change', function() {
        $currentPassword = 'password';
        $newPassword = 'newpassword';

        $userDto = new UserDto(
            name: fake()->name . '-SD',
            email: fake()->unique()->safeEmail(),
            currentPassword: $currentPassword,
            password: $newPassword
        );

        $result = app(UpdateUserAction::class)->handle($userDto);

        expect($result)->toBeTrue();

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => $userDto->name,
            'email' => $userDto->email
        ]);

        $this->assertTrue(Hash::check($newPassword, $this->user->fresh()->password));
    });

    test('cannot update with invalid current password', function() {
        $userDto = new UserDto(
            name: fake()->name,
            email: fake()->unique()->safeEmail(),
            currentPassword: 'wrongpassword',
            password: 'newpassword'
        );

        $result = app(UpdateUserAction::class)->handle($userDto);

        expect($result)->toBeFalse();
        expect($this->user->fresh()->password)->toBe($this->user->password);
    });

    test('can update name only', function() {
        $newName = fake()->name . '-SD';
        $originalEmail = $this->user->email;

        $userDto = new UserDto(
            name: $newName,
            email: $originalEmail
        );

        $result = app(UpdateUserAction::class)->handle($userDto);

        expect($result)->toBeTrue();
        expect($this->user->fresh()->name)->toBe($newName);
        expect($this->user->fresh()->email)->toBe($originalEmail);
    });

    test('can update email only', function() {
        $originalName = $this->user->name;
        $newEmail = fake()->unique()->safeEmail();

        $userDto = new UserDto(
            name: $originalName,
            email: $newEmail
        );

        $result = app(UpdateUserAction::class)->handle($userDto);

        expect($result)->toBeTrue();
        expect($this->user->fresh()->name)->toBe($originalName);
        expect($this->user->fresh()->email)->toBe($newEmail);
    });

    test('password remains unchanged when not provided', function() {
        $originalHash = $this->user->password;

        $userDto = new UserDto(
            name: fake()->name,
            email: fake()->unique()->safeEmail()
        );

        $result = app(UpdateUserAction::class)->handle($userDto);

        expect($result)->toBeTrue();
        expect($this->user->fresh()->password)->toBe($originalHash);
    });
});
