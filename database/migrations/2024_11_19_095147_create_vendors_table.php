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
       Schema::create('vendors', function (Blueprint $table) {
    $table->id();                          // Auto-incrementing ID (primary key)
    $table->string('name')->nullable();    // Vendor's first name (nullable)
    $table->string('last_name')->nullable(); // Vendor's last name (nullable)
    $table->string('email')->unique()->nullable();   // Vendor's email (nullable and unique)
    $table->string('phone')->nullable();
    $table->string('password')->nullable(); // Vendor's password (nullable)
    $table->string('image')->nullable();   // Vendor's profile image (nullable)
    $table->string('city')->nullable();    // Vendor's city (nullable)
    $table->string('address')->nullable(); // Vendor's address (nullable)
    $table->string('status')->default('0'); // Vendor's status, default '0' (inactive)
    $table->string('role')->default('vendor'); // Vendor's role, default 'vendor'
    $table->timestamps();                  // Timestamps for created_at and updated_at
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
