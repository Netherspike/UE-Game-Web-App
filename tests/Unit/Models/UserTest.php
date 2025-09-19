<?php

use App\Models\User;
use App\Models\Character;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => Hash::make('password'),
    ]);

    // Create some characters for relationship testing
    $this->characters = Character::factory()->count(3)->create([
        'user_id' => $this->user->id
    ]);
});

describe('User Model', function () {
    test('has correct attributes', function () {
        expect($this->user)
            ->name->toBe('Test User')
            ->email->toBe('test@example.com')
            ->and(Hash::check('password', $this->user->password))->toBeTrue();
    });

    test('has many characters relationship', function () {
        expect($this->user->characters)
            ->toHaveCount(3)
            ->each->toBeInstanceOf(Character::class);
    });

    test('can be filled with valid attributes', function () {
        $data = [
            'name' => 'New User',
            'email' => 'new@example.com',
        ];

        $user = User::make($data);
        $user->password = Hash::make('newpassword');
        $user->save();

        expect($user)
            ->name->toBe('New User')
            ->email->toBe('new@example.com')
            ->and(Hash::check('newpassword', $user->password))->toBeTrue();
    });

    test('deleting user cascades to characters', function () {
        $characterIds = $this->user->characters->pluck('id');

        $this->user->delete();

        expect(Character::whereIn('id', $characterIds)->count())->toBe(0);
    });

    test('can check if user exists', function () {
        expect(User::where('email', 'test@example.com')->exists())
            ->toBeTrue();
    });

    test('email must be unique', function () {
        expect(fn () => User::create([
            'name' => 'Another User',
            'email' => 'test@example.com', // Already exists
            'password' => Hash::make('password'),
        ]))->toThrow(Exception::class);
    });

    test('password is hashed when setting', function () {
        $this->user->password = 'newpassword';
        $this->user->save();

        expect(Hash::check('newpassword', $this->user->fresh()->password))
            ->toBeTrue();
    });

    test('can get characters count', function () {
        expect($this->user->characters()->count())
            ->toBe(3);
    });
});
