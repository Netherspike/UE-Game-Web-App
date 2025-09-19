<?php

use App\Actions\Item\UpdateItemAction;
use App\Dtos\ItemDto;
use App\Models\Item;
use App\Enums\ItemTypeEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->item = Item::factory()->create([
        'name' => 'original-item',
        'display_name' => 'Original Item',
        'type' => ItemTypeEnum::WEAPON,
        'description' => 'Original description',
        'static_mesh_path' => '/Game/Original/Path'
    ]);
    $this->action = app(UpdateItemAction::class);
});

describe('update item action tests', function () {
    test('can update item with all attributes', function () {
        $itemDto = new ItemDto(
            name: 'updated-item',
            display_name: 'Updated Item',
            type: ItemTypeEnum::QUEST,
            description: 'Updated description',
            static_mesh_path: '/Game/Updated/Path'
        );

        $this->action->handle($this->item, $itemDto);
        $this->item->refresh();

        expect($this->item)
            ->name->toBe('updated-item')
            ->display_name->toBe('Updated Item')
            ->type->toBe(ItemTypeEnum::QUEST)
            ->description->toBe('Updated description')
            ->static_mesh_path->toBe('/Game/Updated/Path');
    });

    test('can partially update item', function () {
        $originalType = $this->item->type;
        $itemDto = new ItemDto(
            display_name: 'Partially Updated Item'
        );

        $this->action->handle($this->item, $itemDto);
        $this->item->refresh();

        expect($this->item)
            ->display_name->toBe('Partially Updated Item')
            ->type->toBe($originalType)
            ->name->toBe('original-item');
    });

    test('preserves json fields when not updated', function () {
        $this->item->stats = ['damage' => 100];
        $this->item->save();

        $itemDto = new ItemDto(
            display_name: 'New Display Name'
        );

        $this->action->handle($this->item, $itemDto);
        $this->item->refresh();

        expect($this->item->stats)->toBe(['damage' => 100]);
    });

    test('returns updated item instance', function () {
        $itemDto = new ItemDto(
            name: 'return-test',
            display_name: 'Return Test'
        );

        $result = $this->action->handle($this->item, $itemDto);

        expect($result)
            ->toBeInstanceOf(Item::class)
            ->name->toBe('return-test')
            ->id->toBe($this->item->id);
    });
});
