<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPurchaseOrderItemTableP7 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_order_item', function (Blueprint $table) {
            $table->integer('packs_quantity')->nullable()->default(null);
            $table->unsignedBigInteger('packs_unit_id')->nullable()->default(null);

            $table->foreign('packs_unit_id')->references('id')->on('purchase_request_item_packs_unit')->onDelete('set null');
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
            $table->dropForeign('purchase_request_packs_unit_id_foreign');
        });

        Schema::table('purchase_request_item', function (Blueprint $table) {
            $table->dropColumn('packs_quantity');
            $table->dropColumn('packs_unit_id');
        });
    }
}