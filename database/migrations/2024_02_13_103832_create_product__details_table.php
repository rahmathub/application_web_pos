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
        Schema::create('product__details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('product_id');
            $table->datetime('product_datetime'); // Menggabungkan tanggal dan waktu menjadi satu kolom
            $table->integer('qty');
            $table->integer('total_buyer');
            $table->string('description', 191);
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('product_id')->references('id')->on('products');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product__details');
    }
};
