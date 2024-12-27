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
        Schema::create('vendor_services', function (Blueprint $table) {
            $table->id();
            
            // Foreign keys for service and package with cascading delete
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('package_id')->constrained('packages')->onDelete('cascade');
            
            // Additional fields related to the vendor service
            $table->decimal('price', 8, 2)->nullable(); // Price of the service (up to 999,999.99)
            $table->string('city')->nullable();         // City where the service is available
            $table->string('pincode')->nullable();
            $table->string('title')->nullable();      // Pincode for the service area
            $table->string('previous_price')->nullable();
            $table->string('time_duration')->nullable();
            $table->text('description')->nullable();    // Additional details about the service
            $table->tinyInteger('status')->default(1);      // Active status: 1 = active, 0 = inactive
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_services');
    }
};
