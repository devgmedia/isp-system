<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyJournalTableP6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('journal', function (Blueprint $table) {
            $table->unsignedBigInteger('posted_by')->nullable()->default(null);
            $table->datetime('submit_at')->nullable()->default(null);
            $table->unsignedBigInteger('submit_by')->nullable()->default(null);

            $table->foreign('posted_by')->references('id')->on('employee')->onDelete('set null');
            $table->foreign('submit_by')->references('id')->on('employee')->onDelete('set null');
        });

        Schema::table('journal', function (Blueprint $table) {
            $table->unsignedBigInteger('ar_invoice_id')->nullable()->default(null);
            $table->foreign('ar_invoice_id')->references('id')->on('ar_invoice')->onDelete('set null');
            $table->unique('ar_invoice_id');

            $table->unsignedBigInteger('ap_invoice_id')->nullable()->default(null);
            $table->foreign('ap_invoice_id')->references('id')->on('ap_invoice')->onDelete('set null');
            $table->unique('ap_invoice_id');

            $table->unsignedBigInteger('cashier_in_id')->nullable()->default(null);
            $table->foreign('cashier_in_id')->references('id')->on('cashier_in')->onDelete('set null');
            $table->unique('cashier_in_id');

            $table->unsignedBigInteger('cashier_out_id')->nullable()->default(null);
            $table->foreign('cashier_out_id')->references('id')->on('cashier_out')->onDelete('set null');
            $table->unique('cashier_out_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
