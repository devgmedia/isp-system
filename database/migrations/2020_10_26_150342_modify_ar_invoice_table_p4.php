<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceTableP4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->unsignedBigInteger('billing_bank_id')->nullable()->default(null);
            $table->string('billing_bank_name')->nullable()->default(null);
            $table->string('billing_bank_account_number')->nullable()->default(null);
            $table->string('billing_bank_account_on_behalf_of')->nullable()->default(null);
            $table->unsignedBigInteger('billing_receiver')->nullable()->default(null);
            $table->string('billing_receiver_name')->nullable()->default(null);
            $table->boolean('available_via_midtrans')->nullable()->default(false);

            $table->foreign('billing_bank_id')->references('id')->on('bank')->onDelete('set null');
            $table->foreign('billing_receiver')->references('id')->on('employee')->onDelete('set null');
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
