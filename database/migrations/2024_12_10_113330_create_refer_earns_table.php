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
        Schema::create('refer_earns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // User earning the amount
            $table->unsignedBigInteger('referrer_id'); // Referrer in the chain
            $table->decimal('credit', 10, 2); // Earned amount
            $table->decimal('debit', 10, 2)->default(0); // Reserved for potential withdrawals
            $table->timestamps();
        
            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('referrer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refer_earns');
    }
};
