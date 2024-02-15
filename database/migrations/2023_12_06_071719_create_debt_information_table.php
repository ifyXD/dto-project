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
        Schema::create('debt_information', function (Blueprint $table) {
            $table->id(); 
            
            $table->string('debtor_name');
            $table->string('debtor_number')->nullable();
            $table->string('debtor_location')->nullable();
            $table->decimal('debt_amount', 10, 2); 
            $table->text('description')->nullable();
            $table->date('issue_date');
            $table->date('due_date');
            $table->string('status')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debt_information');
    }
};
