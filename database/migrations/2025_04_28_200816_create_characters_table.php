<?php

use App\Enums\CharacterClassEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->string('name')->unique();
            $table->string('skeletal_mesh_path')->default("/Script/Engine.SkeletalMesh\'/Game/Characters/Mannequins/Meshes/SKM_Manny.SKM_Manny\'");
            $table->string('animation_class')->default("/Script/Engine.AnimBlueprint\'/Game/Characters/Mannequins/Animations/ABP_Manny.ABP_Manny\'");
            $table->json('materials');
            $table->enum('class', array_map(fn ($item) => $item->value, CharacterClassEnum::cases()));
            $table->enum('gender', ['male', 'female']);
            $table->json('general');
            $table->json('inventory');
            $table->json('stats');
            $table->json('equipment');
            $table->json('skills');
            $table->json('attributes');
            $table->json('abilities');
            $table->json('quests');
            $table->json('additional_data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
