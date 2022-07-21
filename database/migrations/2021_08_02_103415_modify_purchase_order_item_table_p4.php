<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPurchaseOrderItemTableP4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_order_item', function (Blueprint $table) { 
            $table->unsignedBigInteger('customer_id')->nullable()->default(null); 

            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_order_item', function (Blueprint $table) {
            $table->dropForeign('customer_id_foreign');
        });

        Schema::table('purchase_order', function (Blueprint $table) { 
            $table->dropColumn('customer_id'); 
        });
    }
}
