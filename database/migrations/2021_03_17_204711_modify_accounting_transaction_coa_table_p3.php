<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyAccountingTransactionCoaTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounting_transaction_coa', function (Blueprint $table) {
            $table->unsignedBigInteger('coa_card_id')->nullable()->default(null);

            $table->unique([
                'transaction_id',
                'coa_id',
                'coa_card_id',
            ], 'acc_tra_coa_tra_id_coa_id_coa_car_id_unique');
            
            $table->foreign('coa_card_id')->references('id')->on('chart_of_account_card')->onDelete('set null');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounting_transaction_coa', function (Blueprint $table) {
            $table->dropForeign('accounting_transaction_coa_coa_card_id_foreign');
        });

        Schema::table('accounting_transaction_coa', function (Blueprint $table) {
            $table->dropColumn('coa_card_id');
        });
    }
}
