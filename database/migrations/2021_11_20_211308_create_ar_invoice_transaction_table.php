<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArInvoiceTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('ar_invoice_transaction', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->string('alias_name')->nullable()->default(null);

            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->unsignedBigInteger('chart_of_account_title_id')->nullable()->default(null);

            $table->boolean('lock')->nullable()->default(null);

            $table->unsignedBigInteger('debit_coa_id')->nullable()->default(null);
            $table->unsignedBigInteger('debit_coa_card_id')->nullable()->default(null);

            $table->unsignedBigInteger('credit_coa_id')->nullable()->default(null);
            $table->unsignedBigInteger('credit_coa_card_id')->nullable()->default(null);

            $table->timestamps();

            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
            $table->foreign('chart_of_account_title_id')->references('id')->on('chart_of_account_title')->onDelete('set null');

            $table->foreign('debit_coa_id')->references('id')->on('chart_of_account')->onDelete('set null');
            $table->foreign('debit_coa_card_id')->references('id')->on('chart_of_account_card')->onDelete('set null');

            $table->foreign('credit_coa_id')->references('id')->on('chart_of_account')->onDelete('set null');
            $table->foreign('credit_coa_card_id')->references('id')->on('chart_of_account_card')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ar_invoice_transaction');
    }
}
