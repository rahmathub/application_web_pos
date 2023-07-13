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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->datetime('transaction_datetime'); // Menggabungkan tanggal dan waktu menjadi satu kolom
            $table->integer('product_total');
            $table->integer('price_total');
            $table->integer('netto_total');
            $table->integer('accept_customer_money');
            $table->integer('change_customer_money');
            $table->timestamps();
    
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
