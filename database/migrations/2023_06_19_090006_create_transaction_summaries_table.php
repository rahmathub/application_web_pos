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
        Schema::create('transaction_summaries', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->integer('year')->nullable();
            $table->integer('month')->nullable();
            $table->integer('transaction_total');
            $table->integer('sales_total');
            $table->timestamps();

            // code in top i wanna if i jush fill column date not fill column in month and year
            // i set nullable because i think as user if i summary just day or month or year
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_summaries');
    }
};
