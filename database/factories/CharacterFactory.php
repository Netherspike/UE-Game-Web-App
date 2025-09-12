<?php

namespace Database\Factories;

use App\Enums\CharacterClassEnum;
use App\Models\Character;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CharacterFactory extends Factory
{
    protected $model = Character::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->name,
            'skeletal_mesh_path' => $this->faker->filePath(),
            'class' => $this->faker->randomElement(CharacterClassEnum::cases()),
            'gender' => 'male',
        ];
    }
}
