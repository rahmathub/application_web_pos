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
        Schema::create('note_buyer_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('note_buyer_id');
            $table->unsignedBigInteger('product_id');
            $table->string('qty');
            $table->timestamps();

            $table->foreign('note_buyer_id')->references('id')->on('note_buyers');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('note_buyer_details');
    }
};
