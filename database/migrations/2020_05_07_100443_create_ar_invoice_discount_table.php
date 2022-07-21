<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArInvoiceDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('ar_invoice_discount', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ar_invoice_id')->nullable()->default(null);
            $table->unsignedBigInteger('discount_id')->nullable()->default(null);

            $table->string('discount_name')->unique();
            $table->date('discount_effective_date')->nullable()->default(null);
            $table->date('discount_expired_date')->nullable()->default(null);
            $table->tinyInteger('discount_maximum_use')->nullable()->default(null);
            $table->tinyInteger('discount_maximum_use_per_product')->nullable()->default(null);
            $table->tinyInteger('discount_maximum_use_per_product_additional')->nullable()->default(null);
            $table->tinyInteger('discount_maximum_use_per_customer')->nullable()->default(null);
            $table->tinyInteger('discount_maximum_use_per_invoice')->nullable()->default(null);
            $table->unsignedBigInteger('discount_scheme_id')->nullable()->default(null);
            $table->unsignedBigInteger('discount_type_id')->nullable()->default(null);

            $table->timestamps();

            $table->unique(['ar_invoice_id', 'discount_id']);

            $table->foreign('ar_invoice_id')->references('id')->on('ar_invoice')->onDelete('set null');
            $table->foreign('discount_id')->references('id')->on('discount')->onDelete('set null');

            $table->foreign('discount_scheme_id')->references('id')->on('discount_scheme')->onDelete('set null');
            $table->foreign('discount_type_id')->references('id')->on('discount_type')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ar_invoice_discount');
    }
}
