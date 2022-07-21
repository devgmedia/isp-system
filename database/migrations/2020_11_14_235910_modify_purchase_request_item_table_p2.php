<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPurchaseRequestItemTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('purchase_request_item', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->float('price', 15, 2)->change();
            $table->float('total', 15, 2)->nullable(false)->change();
            $table->unsignedBigInteger('item_id')->nullable()->default(null);
            $table->string('item_name')->nullable()->default(null);
            $table->string('item_brand_name')->nullable()->default(null);
            $table->string('item_brand_product_name')->nullable()->default(null);

            $table->unique(['item_id', 'purchase_request_id']);
            $table->foreign('item_id')->references('id')->on('item')->onDelete('set null');
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
            $table->dropForeign('purchase_request_item_item_id_foreign');
        });

        Schema::table('purchase_request_item', function (Blueprint $table) {
            $table->string('name');
            $table->unsignedInteger('price')->change();
            $table->unsignedInteger('total')->nullable()->default(null)->change();
            $table->dropColumn('item_id');
            $table->dropColumn('item_name');
            $table->dropColumn('item_brand_name');
            $table->dropColumn('item_brand_product_name');

            $table->dropUnique('purchase_request_item_item_id_purchase_request_id_unique');
            $table->foreign('item_brand_id')->references('id')->on('item_brand')->onDelete('set null');
            $table->foreign('item_brand_product_id')->references('id')->on('item_brand_product')->onDelete('set null');
        });
    }
}
