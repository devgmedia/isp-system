<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePurchaseRequestItemTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_request_item', function (Blueprint $table) {
            $table->dropColumn('note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // add note purchase_request_item
        Schema::table('purchase_request_item', function (Blueprint $table) {
            $table->text('note')->nullable()->after('total');
        });
    }
}
