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
        Schema::create('vendor_orders', function (Blueprint $table) {
            $table->id();
            
            // Assuming 'orders' and 'customers' tables exist
            $table->string('order_id')->nullable();  // The order ID associated with this vendor order
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');  // Foreign key to customers table, cascading on delete
        
            // Status options: 'pending', 'in_progress', 'completed', 'cancelled', etc.
            $table->string('status')->default('pending');  // Default status as 'pending'
        
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_orders');
    }
};
