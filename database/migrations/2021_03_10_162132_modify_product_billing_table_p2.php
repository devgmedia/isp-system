<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyProductBillingTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_billing', function (Blueprint $table) {
            $table->unsignedBigInteger('receiver')->nullable()->default(null)->change();
        });

        Schema::table('product_billing', function (Blueprint $table) {
            $table->foreign('bank_id')->references('id')->on('bank')->onDelete('set null');
            $table->foreign('receiver')->references('id')->on('employee')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_billing', function (Blueprint $table) {
            $table->dropForeign('product_billing_bank_id_foreign');
            $table->dropForeign('product_billing_receiver_foreign');
        });
    }
}
