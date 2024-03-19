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
        Schema::create('fridge_ingredient', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fridge_id');
            $table->unsignedBigInteger('ingredient_id');
            $table->timestamps();

            $table->foreign('fridge_id')->references('id')->on('fridges')->onDelete('set null');
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fridge_ingredient');
    }
};
