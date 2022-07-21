<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPurchaseOrderItemTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('purchase_order_item', function (Blueprint $table) {
            $table->unsignedBigInteger('purchase_request_id')->nullable()->default(null)->change();
            $table->unsignedBigInteger('source_id')->nullable()->default(null)->change();
        });

        Schema::table('purchase_order_item', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->float('price', 15, 2)->change();
            $table->float('total', 15, 2)->change();
            $table->dropColumn('supplier_id');
            $table->string('purchase_request_number')->nullable()->default(null)->change();
            $table->unsignedBigInteger('purchase_request_item_id')->nullable()->default(null);
            $table->unsignedBigInteger('item_id')->nullable()->default(null);
            $table->string('item_name')->nullable()->default(null);
            $table->string('item_brand_name')->nullable()->default(null);
            $table->string('item_brand_product_name')->nullable()->default(null);

            $table->foreign('purchase_request_item_id')->references('id')->on('purchase_request_item')->onDelete('set null');
            $table->foreign('item_id')->references('id')->on('item')->onDelete('set null');
            $table->foreign('purchase_request_id')->references('id')->on('purchase_request')->onDelete('set null');
            $table->foreign('source_id')->references('id')->on('purchase_order_item_source')->onDelete('set null');
            $table->unique(['item_id', 'purchase_order_id']);
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
            $table->dropForeign('purchase_order_item_purchase_request_item_id_foreign');
            $table->dropForeign('purchase_order_item_item_id_foreign');
            $table->dropForeign('purchase_order_item_purchase_request_id_foreign');
            $table->dropForeign('purchase_order_item_source_id_foreign');
            $table->dropUnique('purchase_order_item_item_id_purchase_order_id_unique');
        });

        Schema::table('purchase_order_item', function (Blueprint $table) {
            $table->string('name');
            $table->unsignedInteger('price')->change();
            $table->unsignedInteger('total')->change();
            $table->unsignedBigInteger('supplier_id')->nullable()->default(null);
            $table->unsignedBigInteger('purchase_request_number')->nullable()->default(null)->change();
            $table->dropColumn('purchase_request_item_id');
            $table->dropColumn('item_id');
            $table->dropColumn('item_name');
            $table->dropColumn('item_brand_name');
            $table->dropColumn('item_brand_product_name');
        });
    }
}
