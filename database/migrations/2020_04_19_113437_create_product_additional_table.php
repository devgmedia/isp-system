<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAdditionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('product_additional', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sid')->unique()->nullable()->default(null);
            $table->string('name');
            $table->unsignedInteger('price');
            $table->boolean('price_include_vat');
            $table->unsignedBigInteger('payment_scheme_id')->nullable()->default(null);
            $table->unsignedInteger('bandwidth')->nullable()->default(null);
            $table->unsignedBigInteger('bandwidth_unit_id')->nullable()->default(null);
            $table->string('description')->nullable()->default(null);
            $table->boolean('required');
            $table->unsignedBigInteger('product_id')->nullable()->default(null);
            $table->timestamps();

            $table->unique(['name', 'product_id']);
            $table->foreign('payment_scheme_id')->references('id')->on('payment_scheme')->onDelete('set null');
            $table->foreign('bandwidth_unit_id')->references('id')->on('bandwidth_unit')->onDelete('set null');
            $table->foreign('product_id')->references('id')->on('product')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_additional');
    }
}
