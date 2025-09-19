<?php

namespace Tests\Unit\Actions\Account;

use App\Actions\Account\DeleteAccountAction;
use App\Models\Character;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->action = app(DeleteAccountAction::class);
});

describe('delete account action tests', function () {
    test('can delete user account', function () {
        $this->action->handle($this->user);

        $this->assertDatabaseMissing('users', [
            'id' => $this->user->id,
        ]);
    });

    test('deletes associated characters when deleting user', function () {
        $character = Character::factory()->create([
            'user_id' => $this->user->id
        ]);

        $this->action->handle($this->user);

        $this->assertDatabaseMissing('characters', [
            'id' => $character->id,
        ]);
    });

    test('logs out user when deleting own account', function () {
        $this->actingAs($this->user);

        $this->action->handle($this->user);

        $this->assertGuest();
    });

    test('admin can delete other user account without logging out', function () {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $this->action->handle($this->user);

        $this->assertAuthenticatedAs($admin);
        $this->assertDatabaseMissing('users', [
            'id' => $this->user->id,
        ]);
    });
});
