<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyProductBillingTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('product_billing', function (Blueprint $table) {
            $table->unsignedBigInteger('cash_bank_id')->nullable()->default(null);
            $table->foreign('cash_bank_id')->references('id')->on('cash_bank')->onDelete('set null');

            $table->string('name')->nullable()->default(null);
            $table->string('address')->nullable()->default(null);
            $table->string('phone_number')->nullable()->default(null);
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
