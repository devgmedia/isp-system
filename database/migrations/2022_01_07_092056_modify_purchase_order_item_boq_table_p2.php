<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPurchaseOrderItemBoqTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_order_item_boq', function (Blueprint $table) {  
            $table->unsignedBigInteger('purchase_order_id')->nullable()->default(NULL); 
            
            $table->foreign('purchase_order_id')->references('id')->on('purchase_order')->onDelete('set null'); 
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
