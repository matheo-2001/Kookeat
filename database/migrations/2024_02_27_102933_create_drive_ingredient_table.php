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
        Schema::create('drive_ingredient', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('drive_id');
            $table->unsignedBigInteger('ingredient_id');
            $table->timestamps();

            $table->foreign('drive_id')->references('id')->on('drives')->onDelete('cascade');
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drive_ingredient');
    }
};
