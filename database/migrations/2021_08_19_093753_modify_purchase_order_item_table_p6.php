<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPurchaseOrderItemTableP6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_order_item', function (Blueprint $table) {   

            $table->dropColumn('unit'); 
            $table->unsignedBigInteger('unit_id')->nullable()->default(null);
 
            $table->foreign('unit_id')->references('id')->on('purchase_order_item_unit')->onDelete('set null');
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
            $table->dropForeign('purchase_order_item_unit_id_foreign'); 
        });

        Schema::table('item_condition', function (Blueprint $table) { 
            $table->dropColumn('unit');  
        });
    }
}
