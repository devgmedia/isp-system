<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyAccountingTransactionTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounting_transaction', function (Blueprint $table) {
            $table->unsignedBigInteger('menu_id')->nullable()->default(null);
            $table->foreign('menu_id')->references('id')->on('accounting_menu')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounting_transaction', function (Blueprint $table) {
            $table->dropForeign('accounting_transaction_menu_id_foreign');
        });

        Schema::table('accounting_transaction', function (Blueprint $table) {
            $table->dropColumn('menu_id');
        });
    }
}
