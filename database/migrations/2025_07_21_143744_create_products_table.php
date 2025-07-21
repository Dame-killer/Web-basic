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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('code');                   // Mã sản phẩm
        $table->string('name');                   // Tên sản phẩm
        $table->text('description')->nullable();  // Mô tả
        $table->unsignedBigInteger('brand_id');   // FK đến brands
        $table->unsignedBigInteger('category_id');// FK đến categories
        $table->timestamps();

    
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
