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
        Schema::create('widthraw_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Use unsignedBigInteger for referencing the user
            $table->string('account_no');
            $table->decimal('amount', 10, 2); // Use decimal for financial amounts (total digits, decimal places)
            $table->enum('status', ['0', '1'])->default('0'); // Enum for status (0 = pending, 1 = completed)
            $table->timestamps();
            
            // Foreign key constraint to reference the users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widthraw_requests');
    }
};
