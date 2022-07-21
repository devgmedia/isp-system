<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_invoice', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ar_invoice_scheme_id')->nullable()->default(NULL);
            $table->string('number');
            $table->date('date');
            $table->date('due_date');
            $table->unsignedInteger('discount');
            $table->unsignedInteger('dpp');
            $table->unsignedInteger('ppn');
            $table->unsignedInteger('total');
            $table->boolean('paid');

            $table->unsignedBigInteger('payer')->nullable()->dafault(NULL);
            $table->string('payer_cid');
            $table->string('payer_name');
            $table->unsignedBigInteger('payer_province_id')->nullable()->default(NULL);
            $table->string('payer_province_name')->nullable()->default(NULL);
            $table->unsignedBigInteger('payer_district_id')->nullable()->default(NULL);
            $table->string('payer_district_name')->nullable()->default(NULL);
            $table->unsignedBigInteger('payer_sub_district_id')->nullable()->default(NULL);
            $table->string('payer_sub_district_name')->nullable()->default(NULL);
            $table->unsignedBigInteger('payer_village_id')->nullable()->default(NULL);
            $table->string('payer_village_name')->nullable()->default(NULL);
            $table->string('payer_address')->nullable()->default(NULL);

            $table->timestamps();

            $table->foreign('ar_invoice_scheme_id')->references('id')->on('ar_invoice_scheme')->onDelete('set null');
            
            $table->foreign('payer')->references('id')->on('customer')->onDelete('set null');
            $table->foreign('payer_province_id')->references('id')->on('province')->onDelete('set null');
            $table->foreign('payer_district_id')->references('id')->on('district')->onDelete('set null');
            $table->foreign('payer_sub_district_id')->references('id')->on('sub_district')->onDelete('set null');
            $table->foreign('payer_village_id')->references('id')->on('village')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ar_invoice');
    }
}
