<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class DropArInvoiceDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::dropIfExists('ar_invoice_detail');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
