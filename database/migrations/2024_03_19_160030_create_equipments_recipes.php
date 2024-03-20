<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipments_recipes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipe_id')->nullable();
            $table->unsignedBigInteger('equipment_id')->nullable();
            $table->timestamps();

            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('set null');
            $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments_recipes');
    }
};
