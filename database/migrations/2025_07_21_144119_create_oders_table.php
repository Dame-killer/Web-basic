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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('name');             // Tên người đặt hàng
            $table->date('order_date');         // Ngày đặt hàng
            $table->string('address');          // Địa chỉ giao hàng
            $table->integer('status')->default(0); // Trạng thái đơn hàng (ví dụ: 0 = chờ xử lý)

            $table->timestamps();               // created_at, updated_at
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oders');
    }
};
