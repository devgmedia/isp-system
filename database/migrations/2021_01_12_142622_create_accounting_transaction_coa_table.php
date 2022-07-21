<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountingTransactionCoaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('accounting_transaction_coa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('transaction_id')->nullable()->default(null);
            $table->unsignedBigInteger('coa_id')->nullable()->default(null);
            $table->date('effective_date');
            $table->timestamps();

            $table->unique(['transaction_id', 'coa_id', 'effective_date'], 'acc_tra_coa_tra_id_coa_id_eff_dat');
            $table->foreign('transaction_id')->references('id')->on('accounting_transaction')->onDelete('set null');
            $table->foreign('coa_id')->references('id')->on('chart_of_account')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounting_transaction_coa');
    }
}
