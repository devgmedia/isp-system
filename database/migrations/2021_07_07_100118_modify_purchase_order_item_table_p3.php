<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPurchaseOrderItemTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('purchase_order_item', function (Blueprint $table) {
            $table->string('unit')->nullable()->default(null);
            $table->unsignedBigInteger('sumber_id')->nullable()->default(null);
            $table->string('number')->nullable()->default(null);
            $table->string('customer_name')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_request_item', function (Blueprint $table) {
            $table->dropColumn('unit');
            $table->dropColumn('number');
            $table->dropColumn('customer_name');
        });
    }
}
