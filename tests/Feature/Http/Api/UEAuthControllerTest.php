<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use function Pest\Laravel\get;
uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password123')
    ]);
});

describe('UE authentication', function () {
    test('can authenticate with valid credentials', function () {
        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson(route('ue.auth.login'), [
                'email' => 'test@example.com',
                'password' => 'password123'
            ]);

        $response->assertOk()
            ->assertJsonStructure([
                'token',
                'user_id'
            ]);
    });

    test('cannot authenticate with invalid credentials', function () {
        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson(route('ue.auth.login'), [
                'email' => 'test@example.com',
                'password' => 'wrongpassword'
            ]);

        $response->assertUnauthorized();
    });

    test('can logout and invalidate token', function () {
        // First login to get token
        $loginResponse = $this->actingAs($this->user, 'sanctum')
            ->postJson(route('ue.auth.login'), [
                'email' => 'test@example.com',
                'password' => 'password123'
            ]);

        $token = $loginResponse->json('token');

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $this->user->id,
        ]);

        $token = $loginResponse->json('token');

        // Then logout with token
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->actingAs($this->user, 'sanctum')
            ->postJson(route('ue.auth.logout'));

        $response->assertOk()
            ->assertJson(['message' => 'Successfully logged out']);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $this->user->id,
        ]);
    });

    test('requires authentication for protected routes', function () {
        $response = $this->getJson(route('ue.characters.index'));

        $response->assertUnauthorized();
    });

    test('can refresh token', function () {
        // First login to get token
        $loginResponse = $this->postJson(route('ue.auth.login'), [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $token = $loginResponse->json('token');

        // Then refresh token
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson(route('ue.auth.refresh'));

        $response->assertOk()
            ->assertJsonStructure(['token']);

        expect($response->json('token'))->not->toBe($token);
    });

    test('validates required fields', function () {
        $response = $this->postJson(route('ue.auth.login'), [
            'email' => '',
            'password' => ''
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['email', 'password']);
    });
});
