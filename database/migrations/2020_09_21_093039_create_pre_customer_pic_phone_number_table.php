<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreCustomerPicPhoneNumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_customer_pic_phone_number', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->unsignedBigInteger('pre_customer_pic_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('pre_customer_id')->nullable()->default(NULL);
            $table->timestamps();

            $table->unique(['number', 'pre_customer_id']);
            $table->foreign('pre_customer_pic_id')->references('id')->on('pre_customer_pic')->onDelete('set null');
            $table->foreign('pre_customer_id')->references('id')->on('pre_customer')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_customer_pic_phone_number');
    }
}
