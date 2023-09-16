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
        Schema::create('otp_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('email', 100)->nullable();
            $table->string('mobile_no', 20)->nullable();
            $table->string('request_for', 75);
            $table->string('otp', 6);
            $table->dateTime('failed_dt')->nullable();
            $table->dateTime('completed_dt')->nullable();
            $table->dateTime('expired_dt')->nullable();
            $table->text('access_code')->nullable();
            $table->dateTime('access_code_dt')->nullable();
            $table->string('status', 50);
            $table->boolean('is_request_complete')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('otp_verifications');
    }
};
