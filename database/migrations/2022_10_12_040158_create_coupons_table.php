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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_code');
            $table->text('description')->nullable();
            $table->string('coupon_type', 15);
            $table->string('discount_type', 15);
            $table->double('discount', 4, 2);
            $table->double('min_order_amount', 6, 2);
            $table->double('max_discount_amount', 6, 2);
            $table->date('expired_at');
            $table->integer('number_of_time_used');
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
};
