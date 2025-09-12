<?php

namespace tests\Unit;

use App\Services\ItemService;
use App\Models\Item;
use App\Enums\ItemTypeEnum;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @var ItemService */
    private $itemService;

    protected function setUp(): void
    {
        parent::setUp();

        // Instantiate the ItemService
        $this->itemService = app(ItemService::class);
    }

    /**
     * Test creating an item.
     */
    public function test_create_item(): void
    {
        $data = [
            'type' => ItemTypeEnum::WEAPON->value,
            'name' => 'Excalibur',
            'display_name' => 'Excalibur',
            'description' => 'test desc',
            'static_mesh_path' => 'test/path/to/static/mesh.usda',
            'general' => ['name' => 'Excalibur', 'description' => 'A legendary weapon.'],
            'stats' => ['damage' => 200, 'durability' => 90],
            'attributes' => ['strength' => 25, 'agility' => 15],
            'abilities' => ['special_move' => 'Holy Slash'],
            'additional_data' => ['origin' => 'mythical'],
        ];

        $item = $this->itemService->createItem($data);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertEquals('Excalibur', $item->general['name']);
        $this->assertEquals(ItemTypeEnum::WEAPON, $item->type);
    }

    /**
     * Test updating an existing item.
     */
    public function test_update_item(): void
    {
        // First, create an item
        $item = $this->itemService->createItem([
            'name' => 'Dragon Hunt',
            'display_name' => 'Dragon Hunt',
            'description' => 'test desc',
            'static_mesh_path' => 'test/path/to/static/mesh.usda',
            'type' => ItemTypeEnum::QUEST->value,
            'general' => ['name' => 'Dragon Hunt', 'description' => 'A perilous quest.'],
            'stats' => ['difficulty' => 8, 'reward' => 5000],
            'attributes' => ['strategy' => 'high', 'teamwork' => 'required'],
            'abilities' => ['skill' => 'dragon-slayer'],
            'additional_data' => ['location' => 'Cave of Elders'],
        ]);

        $updateData = [
            'general' => ['name' => 'Dragon Slayer Quest', 'description' => 'An updated perilous quest.'],
            'stats' => ['difficulty' => 9, 'reward' => 7000],
        ];

        $updatedItem = $this->itemService->updateItem($item, $updateData);

        $this->assertInstanceOf(Item::class, $updatedItem);
        $this->assertEquals('Dragon Slayer Quest', $updatedItem->general['name']);
        $this->assertEquals(7000, $updatedItem->stats['reward']);
        $this->assertEquals(ItemTypeEnum::QUEST, $updatedItem->type);
    }
}
