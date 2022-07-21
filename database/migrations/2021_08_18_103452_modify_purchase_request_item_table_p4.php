<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPurchaseRequestItemTableP4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('purchase_request_item', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->default(null);

            $table->foreign('category_id')->references('id')->on('purchase_request_item_category')->onDelete('set null');
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
            $table->dropForeign('purchase_request_item_category_id_foreign');
        });

        Schema::table('purchase_request_item', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
}
