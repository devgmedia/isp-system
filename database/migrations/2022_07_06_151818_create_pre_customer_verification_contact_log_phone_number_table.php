<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreCustomerVerificationContactLogPhoneNumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('pre_customer_verification_contact_log_phone_number', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->unsignedBigInteger('pre_customer_verification_contact_log_id')->nullable()->default(null);
            $table->unsignedBigInteger('pre_customer_phone_number_id')->nullable()->default(null);
            $table->boolean('sent')->nullable()->default(null);
            $table->dateTime('sent_at')->nullable()->default(null);
            $table->timestamps();

            $table->foreign(
                'pre_customer_verification_contact_log_id',
                'pre_cus_ver_con_log_pre_cus_ver_con_log_pho'
            )
                ->references('id')
                ->on('pre_customer_verification_contact_log')
                ->onDelete('set null');

            $table->foreign(
                'pre_customer_phone_number_id',
                'pre_cus_pho_num_pre_cus_pho_num'
                )
                ->references('id')
                ->on('pre_customer_phone_number')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pre_customer_verification_contact_log_phone_number');
    }
}
