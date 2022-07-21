<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomerPhoneNumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('customer_phone_number', function (Blueprint $table) {
            $table->string('uuid')->nullable()->default(null);

            $table->boolean('whatsapp_verified')->nullable()->default(null);
            $table->datetime('whatsapp_verified_at')->nullable()->default(null);

            $table->datetime('whatsapp_verification_sent_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
