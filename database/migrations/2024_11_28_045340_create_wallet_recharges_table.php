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
        Schema::create('wallet_recharges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade'); // Foreign key to users table
            $table->decimal('amount', 8, 2); // Amount being recharged
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending'); // Recharge status
            $table->string('transaction_id')->unique(); // Transaction ID for external tracking
            $table->timestamp('recharged_at')->nullable(); // Time of recharge
            $table->timestamps(); // Created at and updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_recharges');
    }
};
