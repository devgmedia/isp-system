<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceTableP18 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable()->default(null);
            $table->unsignedBigInteger('agent_id')->nullable()->default(null);
            $table->date('billing_end_date')->nullable()->default(null);
        });
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
