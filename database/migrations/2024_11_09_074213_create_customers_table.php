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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false); // Making name required
            $table->string('email')->unique()->nullable(); // Email should be unique if provided
            $table->string('phone', 13)->unique()->nullable(); // Phone numbers are usually up to 15 characters
            $table->text('address')->nullable(); // Address might be long, so text type is better
            $table->string('city', 100)->nullable();
            $table->string('pin_code')->nullable(); // Limiting the length of the PIN code
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
