<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePurchaseRequestTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // create purchase_request_category_id
        Schema::table('purchase_request', function (Blueprint $table) {
            $table->unsignedBigInteger('purchase_request_category_id')->nullable()->default(null)->after('about');

            $table->foreign('purchase_request_category_id')->references('id')->on('purchase_request_category')->onDelete('set null');
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
            $table->dropForeign(['purchase_request_category_id']);
            $table->dropColumn(['purchase_request_category_id']);
        });
    }
}
