<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashOpnameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_opname', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->unsignedBigInteger('cash_bank_id')->nullable()->default(null);
            $table->unsignedBigInteger('cash_id')->nullable()->default(null);
            $table->unsignedInteger('quantity');
            $table->float('total', 15, 2);
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('cash_bank_id')->references('id')->on('cash_bank')->onDelete('set null');
            $table->foreign('cash_id')->references('id')->on('cash')->onDelete('set null');
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
        Schema::dropIfExists('cash_opname');
    }
}
