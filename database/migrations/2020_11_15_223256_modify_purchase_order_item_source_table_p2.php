<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPurchaseOrderItemSourceTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_order_item_source', function (Blueprint $table) {
            $table->dropColumn('item_brand_id');
            $table->dropColumn('item_brand_product_id');
            $table->dropColumn('name');
            $table->dropColumn('price');
            $table->dropColumn('quantity');
            $table->dropColumn('total');
            $table->dropColumn('supplier_id');
            $table->dropColumn('purchase_request_id');
            $table->dropColumn('purchase_request_number');
            $table->unsignedBigInteger('purchase_request_item_id')->nullable()->default(null);

            $table->foreign('purchase_request_item_id')->references('id')->on('purchase_request_item')->onDelete('set null');
            $table->unique('purchase_request_item_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_order_item_source', function (Blueprint $table) {
            $table->dropForeign('purchase_order_item_source_purchase_request_item_id_foreign');
            $table->dropUnique('purcase_order_item_source_purchase_request_item_id_unique');
        });

        Schema::table('purchase_order_item_source', function (Blueprint $table) {
            $table->unsignedBigInteger('item_brand_id')->nullable()->default(null);
            $table->unsignedBigInteger('item_brand_product_id')->nullable()->default(null);
            $table->string('name');
            $table->unsignedInteger('price');
            $table->unsignedSmallInteger('quantity');
            $table->unsignedInteger('total');
            $table->unsignedBigInteger('supplier_id')->nullable()->default(null);
            $table->unsignedBigInteger('purchase_request_id')->nullable()->default(null);
            $table->string('purchase_request_number')->nullable()->default(null);
            $table->dropColumn('purchase_request_item_id');
        });
    }
}
