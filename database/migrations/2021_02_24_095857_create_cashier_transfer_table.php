<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashierTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('cashier_transfer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->string('name');
            $table->date('date');
            $table->unsignedInteger('nominal');
            $table->unsignedBigInteger('from')->nullable()->default(null);
            $table->unsignedBigInteger('to')->nullable()->default(null);
            $table->unsignedBigInteger('cashier_in_id')->nullable()->default(null);
            $table->unsignedBigInteger('cashier_out_id')->nullable()->default(null);
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->timestamps();

            $table->unique('uuid');
            $table->foreign('from')->references('id')->on('cash_bank')->onDelete('set null');
            $table->foreign('to')->references('id')->on('cash_bank')->onDelete('set null');
            $table->foreign('cashier_in_id')->references('id')->on('cashier_in')->onDelete('set null');
            $table->foreign('cashier_out_id')->references('id')->on('cashier_out')->onDelete('set null');
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
        Schema::dropIfExists('cashier_transfer');
    }
}
