<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreCustomerRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_customer_request', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->string('name');
            $table->string('email')->nullable()->default(null);
            $table->string('phone_number');
            $table->unsignedBigInteger('province_id')->nullable()->default(null);
            $table->unsignedBigInteger('district_id')->nullable()->default(null);
            $table->unsignedBigInteger('sub_district_id')->nullable()->default(null);
            $table->unsignedBigInteger('village_id')->nullable()->default(null);
            $table->string('address')->nullable()->default(null);
            $table->unsignedBigInteger('know_from_id')->nullable()->default(null);
            $table->unsignedBigInteger('need_id')->nullable()->default(null);
            $table->string('need_description')->nullable()->default(null);
            $table->string('device_token')->nullable()->default(null);
            $table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->unsignedBigInteger('submit_by')->nullable()->default(null);
            $table->datetime('submit_at')->nullable()->default(null);
            $table->datetime('sent_to_sales_at')->nullable()->default(null);
            $table->unsignedBigInteger('followed_up_by')->nullable()->default(null);
            $table->datetime('followed_up_at')->nullable()->default(null);
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->timestamps();

            $table->unique('uuid');
            $table->unique('user_id');
            $table->unique('device_token');

            $table->foreign('know_from_id')->references('id')->on('pre_customer_request_know_from')->onDelete('set null');
            $table->foreign('need_id')->references('id')->on('pre_customer_request_need')->onDelete('set null');
            $table->foreign('province_id')->references('id')->on('province')->onDelete('set null');
            $table->foreign('district_id')->references('id')->on('district')->onDelete('set null');
            $table->foreign('sub_district_id')->references('id')->on('sub_district')->onDelete('set null');
            $table->foreign('village_id')->references('id')->on('village')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
            $table->foreign('submit_by')->references('id')->on('employee')->onDelete('set null');
            $table->foreign('followed_up_by')->references('id')->on('employee')->onDelete('set null');
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_customer_request');
    }
}
