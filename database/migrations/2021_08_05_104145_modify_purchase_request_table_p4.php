<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPurchaseRequestTableP4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('purchase_request', function (Blueprint $table) {
            $table->unsignedBigInteger('supplier_id')->nullable()->default(null);

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
        Schema::table('purchase_request', function (Blueprint $table) {
            $table->dropForeign('purchase_request_supplier_id');
        });

        Schema::table('purchase_request', function (Blueprint $table) {
            $table->dropColumn('supplier_id');
        });
    }
}
