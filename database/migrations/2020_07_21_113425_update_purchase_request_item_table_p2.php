<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePurchaseRequestItemTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        // add supplier_id purchase_request_item
        Schema::table('purchase_request_item', function (Blueprint $table) {
            $table->unsignedBigInteger('supplier_id')->nullable()->default(null)->after('total');

            $table->foreign('supplier_id')->references('id')->on('supplier')->onDelete('set null');
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
            $table->dropColumn(['supplier_id']);
        });
    }
}
