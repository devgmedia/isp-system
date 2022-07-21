<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('customer_discount', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('registration_date');
            $table->unsignedBigInteger('customer_id')->nullable()->default(null);
            $table->unsignedBigInteger('discount_id')->nullable()->default(null);
            $table->date('start_date');
            $table->date('end_date');
            $table->tinyInteger('total_usage');

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

            $table->unique(['customer_id', 'discount_id']);

            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('set null');
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
        Schema::dropIfExists('customer_discount');
    }
}
