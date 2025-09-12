<?php

namespace Database\Factories;

use App\Enums\ItemTypeEnum;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(ItemTypeEnum::cases()), // Dynamically use all ItemType cases
            'name' => $this->faker->words(3, true), // Random display name
            'display_name' => $this->faker->words(3, true), // Random display name
            'description' => $this->faker->sentence(), // Random description
            'thumbnail_path' => $this->faker->imageUrl(), // Random thumbnail path
            'static_mesh_path' => $this->faker->filePath(), // Random file path
            'created_at' => now(), // Set the current timestamp
            'updated_at' => now(), // Set the current timestamp
        ];
    }
}
