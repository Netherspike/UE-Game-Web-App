<?php

use App\Actions\Account\CreateAccountAction;
use App\Dtos\UserDto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->action = app(CreateAccountAction::class);
});

describe('create account action tests', function () {
    test('can create user with valid data', function () {
        $userDto = new UserDto(
            name: 'Test User',
            email: 'test@example.com',
            password: 'password'
        );

        $this->action->handle($userDto);

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    });

    test('hashes password when creating user', function () {
        $userDto = new UserDto(
            name: 'Test User',
            email: 'test@example.com',
            password: 'password'
        );

        $user = $this->action->handle($userDto);

        expect(Hash::check('password', $user->password))->toBeTrue();
    });

    test('returns created user instance', function () {
        $userDto = new UserDto(
            name: 'Test User',
            email: 'test@example.com',
            password: 'password'
        );

        $result = $this->action->handle($userDto);

        expect($result)
            ->toBeInstanceOf(User::class)
            ->name->toBe('Test User')
            ->email->toBe('test@example.com');
    });

    test('sets default values for new user', function () {
        $userDto = new UserDto(
            name: 'Test User',
            email: 'test@example.com',
            password: 'password'
        );

        $user = $this->action->handle($userDto);

        expect($user)->email_verified_at->toBeNull();
    });
});
