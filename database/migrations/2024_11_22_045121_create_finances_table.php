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
        Schema::create('finances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id'); // Foreign key for vendors table
            $table->json('gst_details')->nullable(); // Store GST data in JSON format
            $table->json('pan_card_details')->nullable(); // Store PAN card data in JSON format
            $table->json('bank_details')->nullable(); // Store bank data in JSON format
            $table->json('personal_details')->nullable(); // Store personal details in JSON format
            $table->timestamps();
        
            // Add foreign key constraint
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        
            
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finances');
    }
};
