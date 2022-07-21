<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPurchaseOrderShippingAddressTableP1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('purchase_order_shipping_address', function (Blueprint $table) {
            $table->string('email')->nullable()->default(null);
            $table->string('phone_number')->nullable()->default(null);
            $table->string('fax')->nullable()->default(null);
            $table->string('address')->nullable()->default(null);
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
