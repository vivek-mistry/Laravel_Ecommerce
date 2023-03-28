<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->string('brand_name', 255);
            $table->string('product_name', 255);
            $table->double('product_price', 6, 2);
            $table->double('product_sale_price', 6, 2);
            $table->text('description')->nullable();
            $table->text('product_url')->nullable();
            $table->string('color_name', 255);
            $table->json('product_size');
            // $table->json('product_image_urls');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
