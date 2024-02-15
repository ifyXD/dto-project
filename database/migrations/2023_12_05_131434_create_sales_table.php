<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // $table->unsignedBigInteger('product_id'); 
            // $table->foreign('product_id')->references('id')->on('products');
            $table->unsignedBigInteger('product_id')->nullable();

            $table->unsignedBigInteger('reports_id');
            $table->foreign('reports_id')->references('id')->on('sales_reports');

            $table->string('name');
            $table->unsignedInteger('quantity');
            $table->decimal('price', 8, 2);
            $table->unsignedInteger('stock');
            $table->unsignedInteger('subtotal');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};

