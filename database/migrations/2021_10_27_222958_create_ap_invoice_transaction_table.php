<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApInvoiceTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('ap_invoice_transaction', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->unsignedBigInteger('chart_of_account_title_id')->nullable()->default(null);
            $table->unsignedBigInteger('chart_of_account_id')->nullable()->default(null);
            $table->unsignedBigInteger('chart_of_account_card_id')->nullable()->default(null);

            $table->boolean('lock')->nullable()->default(null);

            $table->timestamps();

            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
            $table->foreign('chart_of_account_title_id')->references('id')->on('chart_of_account_title')->onDelete('set null');
            $table->foreign('chart_of_account_id')->references('id')->on('chart_of_account')->onDelete('set null');
            $table->foreign('chart_of_account_card_id')->references('id')->on('chart_of_account_card')->onDelete('set null');

            $table->unique(['name', 'chart_of_account_title_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ap_invoice_transaction');
    }
}
