<?php

use App\Actions\Item\DeleteItemAction;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->item = Item::factory()->create([
        'name' => 'test-item',
        'display_name' => 'Test Item'
    ]);
    $this->action = app(DeleteItemAction::class);
});

describe('delete item action tests', function () {
    test('can delete item', function () {
        $this->action->handle($this->item);

        $this->assertDatabaseMissing('items', [
            'id' => $this->item->id
        ]);
    });
});
