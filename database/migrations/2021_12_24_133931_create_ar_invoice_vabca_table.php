<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArInvoiceVabcaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_invoice_vabca', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('ar_invoice_id')->nullable()->default(null);
            $table->foreign('ar_invoice_id')->references('id')->on('ar_invoice')->onDelete('set null');

            $table->string('company_code');
            $table->string('customer_number');
            $table->string('request_id');
            $table->string('channel_type');
            $table->string('customer_name');
            $table->string('currency_code');

            $table->float('paid_amount', 15, 2);
            $table->float('total_amount', 15, 2);

            $table->datetime('transaction_date');

            $table->string('flag_advice');
            $table->string('sub_company');
            $table->string('reference');
            $table->string('detail_bills')->nullable()->default(null);
            $table->string('additional_data')->nullable()->default(null);
            $table->string('channel_type_description')->nullable()->default(null);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ar_invoice_vabca');
    }
}
