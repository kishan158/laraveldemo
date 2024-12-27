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
    {Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('service_id'); // Foreign key for category
        $table->unsignedBigInteger('subcategory_id'); // Foreign key for subcategory
        $table->string('product_name');
        $table->string('price');
        $table->text('image');
        $table->timestamps();
    
        // Foreign key constraints
        $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        $table->foreign('subcategory_id')->references('id')->on('sub_categories')->onDelete('cascade');
    });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
