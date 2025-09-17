<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Character;
use App\Models\Item;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Create Admin user
        $adminUser = User::factory()->create([
            'email' => 'admin@game.com',
            'is_admin' => 1
        ]);

        //Create between 1 to 5 characters for the admin user
        Character::factory(rand(1, 5))->create(['user_id' => $adminUser->id]);

        // Create 10 users and for each user, create between 1 to 5 characters.
        User::factory(10)->create()->each(function ($user) {
            // Assign characters to each user
            Character::factory(rand(1, 5))->create(['user_id' => $user->id]);
        });

        // Create items
        Item::factory(20)->create();
    }
}
