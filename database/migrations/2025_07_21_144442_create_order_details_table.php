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
        Schema::create('order_details', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('order_id');
        $table->unsignedBigInteger('product_detail_id')->nullable(); // nếu có biến thể
        $table->integer('quantity');
        $table->integer('price'); // đơn giá tại thời điểm mua

        $table->timestamps();

        // Khóa ngoại
        // $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        // $table->foreign('product_detail_id')->references('id')->on('product_details')->onDelete('set null');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
