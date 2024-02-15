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
        Schema::create('debt_logs', function (Blueprint $table) {
            
            $table->id(); 
            $table->unsignedBigInteger('debt_info_id')->nullable();
            $table->string('name')->nullable();
            $table->date('date');
            $table->decimal('amount', 10, 2); 
            $table->string('log_status')->nullable(); 
            $table->foreign('debt_info_id')->references('id')->on('debt_information')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debt_logs');
    }
};
