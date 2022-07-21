<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreCustomerVerificationContactLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_customer_verification_contact_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->unsignedBigInteger('pre_customer_id')->nullable()->default(null);
            $table->string('number')->nullable()->default(null);
            $table->timestamps();

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
        Schema::drop('pre_customer_verification_contact_log');
    }
}
