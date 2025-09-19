<?php

use App\Enums\ItemTypeEnum;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['is_admin' => true]);
    $this->regularUser = User::factory()->create(['is_admin' => false]);
    $this->item = Item::factory()->create([
        'name' => 'Test Item',
        'display_name' => 'Test Item Display',
    ]);
});

describe('item management', function () {
    test('non-admin cannot access item management', function () {
        $response = $this->actingAs($this->regularUser)
            ->get(route('items.index'));

        $response->assertRedirect();
    });

    test('admin can view items list', function () {
        $response = $this->actingAs($this->admin)
            ->get(route('items.index'));

        $response->assertOk()
            ->assertViewIs('management.items.index')
            ->assertViewHas('items')
            ->assertSee('Test Item');
    });

    test('admin can create new item', function () {
        $response = $this->actingAs($this->admin)
            ->post(route('items.store'), [
                'name' => 'New Item',
                'display_name' => 'New Item Display',
                'type' => ItemTypeEnum::WEAPON->value,
                'description' => 'SWORD',
                'static_mesh_path' => '/path/to/mesh',
            ]);

        $response->assertRedirect(route('items.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('items', [
            'name' => 'New Item',
            'display_name' => 'New Item Display',
        ]);
    });

    test('admin can view item details', function () {
        $response = $this->actingAs($this->admin)
            ->get(route('items.show', $this->item));

        $response->assertOk()
            ->assertViewIs('management.items.show')
            ->assertViewHas('item')
            ->assertSee($this->item->name);
    });

    test('admin can update item', function () {
        $response = $this->actingAs($this->admin)
            ->put(route('items.update', $this->item), [
                'name' => 'Updated Item',
                'display_name' => 'Updated Display Name',
            ]);

        $response->assertRedirect(route('items.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('items', [
            'id' => $this->item->id,
            'name' => 'Updated Item',
            'display_name' => 'Updated Display Name',
        ]);
    });

    test('admin can delete item', function () {
        $response = $this->actingAs($this->admin)
            ->delete(route('items.destroy', $this->item));

        $response->assertRedirect(route('items.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('items', [
            'id' => $this->item->id,
        ]);
    });

    test('validates required fields when creating item', function () {
        $response = $this->actingAs($this->admin)
            ->post(route('items.store'), [
                'name' => '',
                'display_name' => '',
            ]);

        $response->assertSessionHasErrors(['name', 'display_name']);
    });

    test('ajax search returns json response', function () {
        $response = $this->actingAs($this->admin)
            ->get(route('items.index', ['search' => 'Test']), [
                'HTTP_X-Requested-With' => 'XMLHttpRequest'
            ]);

        $response->assertOk()
            ->assertJson(['html' => true]);
    });
});
