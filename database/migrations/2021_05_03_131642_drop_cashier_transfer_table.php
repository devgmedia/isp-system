<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropCashierTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('cashier_transfer');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('cashier_transfer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->string('name');
            $table->date('date');
            $table->unsignedInteger('total');
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
}
