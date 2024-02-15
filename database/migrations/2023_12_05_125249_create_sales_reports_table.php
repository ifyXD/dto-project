<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales_reports', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->decimal('cash', 10, 2);
            $table->decimal('total', 10, 2);
            $table->decimal('balance', 10, 2);
            $table->date('date');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_reports');
    }
};
