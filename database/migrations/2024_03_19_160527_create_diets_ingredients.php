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
        Schema::create('diets_ingredients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ingredient_id')->nullable();
            $table->unsignedBigInteger('diet_id')->nullable();
            $table->timestamps();

            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('set null');
            $table->foreign('diet_id')->references('id')->on('diets')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diets_ingredients');
    }
};
