<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePurchaseRequestTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // create relation to purchase_request_status table and add field name to purchase_request table
        Schema::table('purchase_request', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->unsignedBigInteger('purchase_request_status_id')->nullable()->default(null)->after('purchase_request_category_id');

            $table->foreign('purchase_request_status_id')->references('id')->on('purchase_request_status')->onDelete('set null');
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
            $table->dropForeign(['purchase_request_status_id']);
            $table->dropColumn(['name', 'purchase_request_status_id']);
        });
    }
}
