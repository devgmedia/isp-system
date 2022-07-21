<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArInvoiceDetailProductAdditionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('ar_invoice_detail_product_additional', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('product_additional_id');
            $table->foreign('product_additional_id', 'ap_id_ref')->references('id')->on('product_additional');

            $table->unsignedBigInteger('ar_invoice_detail_id');
            $table->foreign('ar_invoice_detail_id', 'aid_id_ref')->references('id')->on('ar_invoice_detail');

            $table->double('price', 20, 2);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ar_invoice_detail_product_additional');
    }
}
