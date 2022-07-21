<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomerPhoneNumberTableP2 extends Migration
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
            $table->boolean('whatsapp')->nullable()->default(false);
            $table->boolean('telegram')->nullable()->default(false);
            $table->boolean('home')->nullable()->default(false);
            $table->boolean('office')->nullable()->default(false);
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
