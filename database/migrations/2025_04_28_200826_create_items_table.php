<?php

use App\Enums\ItemTypeEnum;
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
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            // Dynamically populate enum values from ItemTypeEnum
            $table->enum('type', array_map(fn ($item) => $item->value, ItemTypeEnum::cases()));

            $table->integer('value')->nullable()->default(0);
            $table->boolean('active')->default(true);
            $table->string('name')->unique();
            $table->string('display_name')->unique();
            $table->string('description');
            $table->string('thumbnail_path')->nullable()->default(null); //TODO: default this to an image
            $table->string('static_mesh_path');
            $table->json('general');
            $table->json('stats');
            $table->json('attributes');
            $table->json('abilities');
            $table->json('additional_data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
