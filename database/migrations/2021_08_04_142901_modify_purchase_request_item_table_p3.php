<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPurchaseRequestItemTableP3 extends Migration
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
            $table->string('name')->nullable()->default(null);
            $table->unsignedBigInteger('unit_id')->nullable()->default(null);
            $table->unsignedBigInteger('source_id')->nullable()->default(null);
            $table->string('number')->nullable()->default(null);
            $table->string('customer_name')->nullable()->default(null);
            $table->unsignedBigInteger('customer_id')->nullable()->default(null);

            $table->foreign('unit_id')->references('id')->on('purchase_request_item_unit')->onDelete('set null');
            $table->foreign('source_id')->references('id')->on('purchase_request_item_source')->onDelete('set null');
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
        Schema::table('purchase_request_item', function (Blueprint $table) {
            $table->dropForeign('purchase_request_item_sumber_id_foreign');
            $table->dropForeign('purchase_request_item_unit_id_foreign');
            $table->dropForeign('purchase_request_item_customer_id_foreign');
        });

        Schema::table('purchase_request_item', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('unit_id');
            $table->dropColumn('number');
            $table->dropColumn('sumber_id');
            $table->dropColumn('customer_name');
            $table->dropColumn('customer_id');
        });
    }
}
