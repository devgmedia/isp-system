<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerPicPhoneNumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_pic_phone_number', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->unsignedBigInteger('customer_pic_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('customer_id')->nullable()->default(NULL);
            $table->timestamps();

            $table->unique(['number', 'customer_id']);
            $table->foreign('customer_pic_id')->references('id')->on('customer_pic')->onDelete('set null');
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_pic_phone_number');
    }
}
