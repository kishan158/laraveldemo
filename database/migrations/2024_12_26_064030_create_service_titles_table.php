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
        Schema::create('service_titles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id')->nullable(); // Use unsignedBigInteger for FK
            $table->string('service_title')->nullable();
            $table->text('image')->nullable();
            $table->timestamps();
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_titles');
    }
};