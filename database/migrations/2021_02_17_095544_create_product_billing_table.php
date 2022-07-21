<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductBillingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('product_billing', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->nullable()->default(null);
            $table->string('email');
            $table->unsignedBigInteger('bank_id')->nullable()->default(null);
            $table->string('bank_account_number');
            $table->string('bank_account_on_behalf_of');
            $table->string('receiver');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('product')->onDelete('set null');
            $table->unique(['email', 'product_id']);
            $table->unique(['bank_account_number', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_billing');
    }
}
