<?php

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
        Schema::create('home_customizes', function (Blueprint $table) {
            $table->id();  // auto-incrementing primary key
            $table->text('title')->nullable();  // Title, can be null
            $table->text('banner1')->nullable();  // First banner, can be null
            $table->text('banner2')->nullable();  // Second banner, can be null
            $table->text('banner3')->nullable();  // Third banner, can be null
            $table->text('banner4')->nullable();  // Fourth banner, can be null
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_customizes');
    }
};
