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
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('user_id');
            // $table->unsignedBigInteger('product_id')->nullable();
            $table->string('product_name')->nullable();
            $table->decimal('product_price', 10, 2)->nullable();
            $table->integer('product_qty')->nullable();
            
            // $table->unsignedBigInteger('debt_log_id')->nullable();
            // $table->unsignedBigInteger('debt_info_id')->nullable();
            
            // $table->foreign('product_id')->references('id')->on('products');
            // $table->foreign('debt_log_id')->references('id')->on('debt_logs')->onDelete('set null');
            // $table->foreign('debt_info_id')->references('id')->on('debt_information')->onDelete('cascade');
            
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debts');
    }
};
