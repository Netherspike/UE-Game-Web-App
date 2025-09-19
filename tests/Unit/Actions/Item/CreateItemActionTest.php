<?php

use App\Actions\Item\CreateItemAction;
use App\Dtos\ItemDto;
use App\Models\Item;
use App\Enums\ItemTypeEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->action = app(CreateItemAction::class);
});

describe('create item action tests', function () {
    test('can create item with valid data', function () {
        $itemDto = new ItemDto(
            name: 'test-item',
            display_name: 'Test Item',
            type: ItemTypeEnum::WEAPON,
            description: 'A test item',
            static_mesh_path: '/Game/Path/To/Mesh'
        );

        $this->action->handle($itemDto);

        $this->assertDatabaseHas('items', [
            'name' => 'test-item',
            'display_name' => 'Test Item',
            'type' => ItemTypeEnum::WEAPON->value,
            'description' => 'A test item',
            'static_mesh_path' => '/Game/Path/To/Mesh'
        ]);
    });

    test('creates item with default values', function () {
        $itemDto = new ItemDto(
            name: 'basic-item',
            display_name: 'Basic Item',
            type: ItemTypeEnum::WEAPON,
            description: 'Testing return value',
            static_mesh_path: '/Game/Path/To/Mesh'
        );

        $this->action->handle($itemDto);

        $item = Item::where('name', 'basic-item')->first();

        expect($item)
            ->description->toBe('Testing return value')
            ->static_mesh_path->toBe('/Game/Path/To/Mesh')
            ->stats->toBe([])
            ->additional_data->toBe([]);
    });

    test('returns created item instance', function () {
        $itemDto = new ItemDto(
            name: 'return-test',
            display_name: 'Return Test',
            type: ItemTypeEnum::WEAPON,
            description: 'Testing return value',
            static_mesh_path: '/Game/Path/To/Mesh'
        );

        $result = $this->action->handle($itemDto);

        expect($result)
            ->toBeInstanceOf(Item::class)
            ->name->toBe('return-test')
            ->display_name->toBe('Return Test');
    });
});
