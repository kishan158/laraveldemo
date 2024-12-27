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
        Schema::create('avalibalities', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // Use the 'date' column type for storing dates
            $table->foreignId('vendor_id')->constrained()->onDelete('cascade'); // Proper foreign key reference
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avalibalities');
    }
};
