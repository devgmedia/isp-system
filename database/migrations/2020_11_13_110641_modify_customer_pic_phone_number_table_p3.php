<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomerPicPhoneNumberTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('customer_pic_phone_number', function (Blueprint $table) {
            $table->dropUnique('customer_pic_phone_number_number_customer_id_unique');
            $table->unique(['number', 'customer_pic_id']);
            $table->dropForeign('customer_pic_phone_number_customer_id_foreign');
        });

        Schema::table('customer_pic_phone_number', function (Blueprint $table) {
            $table->dropColumn('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_pic_phone_number', function (Blueprint $table) {
            $table->unique(['number', 'customer_id']);
            $table->dropUnique('customer_pic_phone_number_number_customer_pic_id_unique');
            $table->unsignedBigInteger('customer_id')->nullable()->default(null);

            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('set null');
        });
    }
}
