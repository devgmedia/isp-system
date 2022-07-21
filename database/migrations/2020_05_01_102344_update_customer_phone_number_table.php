<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCustomerPhoneNumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('customer_phone_number', function (Blueprint $table) {
            $table->dropForeign('customer_phone_number_customer_id_foreign');
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_phone_number', function (Blueprint $table) {
            $table->dropForeign('customer_phone_number_customer_id_foreign');
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('set null');
        });
    }
}
