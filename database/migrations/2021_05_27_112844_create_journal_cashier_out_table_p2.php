<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalCashierOutTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_cashier_out', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('journal_id')->nullable()->default(null);
            $table->unsignedBigInteger('cashier_out_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('journal_id')->references('id')->on('journal')->onDelete('set null');
            $table->foreign('cashier_out_id')->references('id')->on('cashier_out')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journal_cashier_out');
    }
}
