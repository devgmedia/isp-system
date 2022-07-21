<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashierInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashier_in', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->string('name');
            $table->unsignedBigInteger('bank_id')->nullable()->default(null);
            $table->unsignedBigInteger('cash_id')->nullable()->default(null);
            $table->date('date');
            $table->unsignedInteger('nominal');
            $table->unsignedBigInteger('category_id')->nullable()->default(null);
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->timestamps();

            $table->unique('uuid');

            $table->foreign('bank_id')->references('id')->on('finance_bank')->onDelete('set null');
            $table->foreign('cash_id')->references('id')->on('finance_cash')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('cashier_in_category')->onDelete('set null');
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
        Schema::dropIfExists('cashier_in');
    }
}
