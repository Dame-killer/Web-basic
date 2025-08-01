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
        Schema::create('product_details', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('product_id');
        $table->unsignedBigInteger('size_id')->nullable();
        $table->unsignedBigInteger('color_id')->nullable();
        $table->unsignedBigInteger('power_id')->nullable();

        $table->integer('stock')->default(0); // số lượng tồn kho

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
