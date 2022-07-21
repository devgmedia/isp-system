<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyJournalItemTableP6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journal_item', function (Blueprint $table) {
            $table->unsignedBigInteger('journal_ar_invoice_id')->nullable()->default(null);
            $table->foreign('journal_ar_invoice_id')->references('id')->on('journal_ar_invoice')->onDelete('set null');

            $table->unsignedBigInteger('journal_ap_invoice_id')->nullable()->default(null);
            $table->foreign('journal_ap_invoice_id')->references('id')->on('journal_ap_invoice')->onDelete('set null');

            $table->unsignedBigInteger('journal_cashier_in_id')->nullable()->default(null);
            $table->foreign('journal_cashier_in_id')->references('id')->on('journal_cashier_in')->onDelete('set null');

            $table->unsignedBigInteger('journal_cashier_out_id')->nullable()->default(null);
            $table->foreign('journal_cashier_out_id')->references('id')->on('journal_cashier_out')->onDelete('set null');
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
