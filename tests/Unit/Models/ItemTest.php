<?php

use App\Enums\ItemTypeEnum;
use App\Enums\WeaponTypeEnum;
use App\Models\Item;
use App\Models\Character;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->character = Character::factory()->create();
    $this->item = Item::factory()->create([
        'name' => 'Test Item',
        'type' => ItemTypeEnum::WEAPON,
        'description' => 'A test item',
        'display_name' => 'New Item Display',
    ]);
});

describe('Item Model', function () {
    test('has correct attributes', function () {
        expect($this->item)
            ->name->toBe('Test Item')
            ->type->toBe(ItemTypeEnum::WEAPON)
            ->description->toBe('A test item');
    });

    test('has correct default json attributes', function () {
        $newItem = Item::factory()->create();

        expect($newItem)
            ->stats->toBe([])
            ->additional_data->toBe([]);
    });

    test('can be filled with valid attributes', function () {
        $data = [
            'name' => 'New Item',
            'type' => ItemTypeEnum::MISC,
            'description' => 'A new test item',
            'display_name' => 'New Item Display',
            'static_mesh_path' => '/path/to/mesh',
            'thumbnail_path' => '/path/to/thumbnail',
            'value' => 100,
            'general' => ['rarity' => 'common'],
        ];

        $item = Item::create($data);

        expect($item)
            ->name->toBe('New Item')
            ->type->toBe(ItemTypeEnum::MISC)
            ->description->toBe('A new test item')
            ->value->toBe(100)
            ->general->toBe(['rarity' => 'common']);
    });

    test('json fields can be updated directly', function () {
        $this->item->stats = ['damage' => 100];
        $this->item->save();

        $this->item->refresh();

        expect($this->item->stats)
            ->toBe(['damage' => 100]);
    });

    test('can check if item exists', function () {
        expect(Item::where('name', 'Test Item')->exists())
            ->toBeTrue();
    });
});
