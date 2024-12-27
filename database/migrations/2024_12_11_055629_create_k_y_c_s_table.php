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
        Schema::create('k_y_c_s', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('user_id');
            $table->string('name')->nullable(); 
            $table->text('pan_no')->unique()->nullable(); 
            $table->text('adhar_no')->unique()->nullable();
            $table->text('bank_name'); 
            $table->text('account_no')->unique()->nullable(); 
            $table->text('bank_branch'); 
            $table->text('bank_ifsc'); 
            $table->string('status')->default(0); 
            $table->timestamps(); 
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('k_y_c_s');
    }
};
