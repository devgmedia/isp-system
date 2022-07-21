<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('discount', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->date('effective_date')->nullable()->default(null);
            $table->date('expired_date')->nullable()->default(null);
            $table->tinyInteger('maximum_use')->nullable()->default(null);
            $table->tinyInteger('maximum_use_per_product')->nullable()->default(null);
            $table->tinyInteger('maximum_use_per_product_additional')->nullable()->default(null);
            $table->tinyInteger('maximum_use_per_customer')->nullable()->default(null);
            $table->tinyInteger('maximum_use_per_invoice')->nullable()->default(null);
            $table->unsignedBigInteger('scheme_id')->nullable()->default(null);
            $table->unsignedBigInteger('type_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('scheme_id')->references('id')->on('discount_scheme')->onDelete('set null');
            $table->foreign('type_id')->references('id')->on('discount_type')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount');
    }
}
