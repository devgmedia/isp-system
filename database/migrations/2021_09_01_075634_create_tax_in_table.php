<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('tax_in', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ap_invoice_id')->nullable()->default(null);
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->unsignedBigInteger('chart_of_account_title_id')->nullable()->default(null);
            $table->boolean('submit')->nullable()->default(null);
            $table->unsignedBigInteger('submit_by')->nullable()->default(null);
            $table->datetime('submit_at')->nullable()->default(null);
            $table->float('pph_pasal_21', 15, 2)->nullable()->default(0);
            $table->float('pph_pasal_23', 15, 2)->nullable()->default(0);
            $table->float('pph_pasal_4_ayat_2', 15, 2)->nullable()->default(0);
            $table->float('ppn', 15, 2)->nullable()->default(0);
            $table->string('bukti_potong')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('ap_invoice_id')->references('id')->on('ap_invoice')->onDelete('set null');
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
            $table->foreign('chart_of_account_title_id')->references('id')->on('chart_of_account_title')->onDelete('set null');
            $table->foreign('submit_by')->references('id')->on('employee')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax_in');
    }
}
