<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArInvoiceReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('ar_invoice_receipt', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('ar_invoice_id')->nullable()->default(null);

            $table->string('number');
            $table->string('name');
            $table->date('date');
            $table->date('due_date');
            $table->double('price');
            $table->double('discount');
            $table->double('dpp');
            $table->double('ppn');
            $table->double('total');
            $table->double('remaining_payment')->nullable()->default(0);
            $table->double('previous_remaining_payment')->nullable()->default(0);
            $table->double('paid_total')->nullable()->default(0);
            $table->date('payment_date')->nullable()->dafault(null);
            $table->date('billing_date')->nullable()->dafault(null);

            $table->unsignedBigInteger('payer')->nullable()->dafault(null);
            $table->string('payer_cid')->nullable()->dafault(null);
            $table->string('payer_name')->nullable()->dafault(null);
            $table->unsignedBigInteger('payer_province_id')->nullable()->default(null);
            $table->string('payer_province_name')->nullable()->default(null);
            $table->unsignedBigInteger('payer_district_id')->nullable()->default(null);
            $table->string('payer_district_name')->nullable()->default(null);
            $table->unsignedBigInteger('payer_sub_district_id')->nullable()->default(null);
            $table->string('payer_sub_district_name')->nullable()->default(null);
            $table->unsignedBigInteger('payer_village_id')->nullable()->default(null);
            $table->string('payer_village_name')->nullable()->default(null);
            $table->string('payer_address')->nullable()->default(null);
            $table->string('payer_postal_code')->nullable()->default(null);
            $table->string('payer_phone_number')->nullable()->default(null);
            $table->string('payer_fax')->nullable()->default(null);
            $table->string('payer_email')->nullable()->default(null);

            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->string('brand_name')->nullable()->default(null);

            $table->timestamps();

            $table->foreign('ar_invoice_id')->references('id')->on('ar_invoice')->onDelete('set null');

            $table->foreign('payer')->references('id')->on('customer')->onDelete('set null');
            $table->foreign('payer_province_id')->references('id')->on('province')->onDelete('set null');
            $table->foreign('payer_district_id')->references('id')->on('district')->onDelete('set null');
            $table->foreign('payer_sub_district_id')->references('id')->on('sub_district')->onDelete('set null');
            $table->foreign('payer_village_id')->references('id')->on('village')->onDelete('set null');

            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ar_invoice_receipt');
    }
}
