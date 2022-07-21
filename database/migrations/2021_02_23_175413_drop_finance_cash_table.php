<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropFinanceCashTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('finance_cash');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('finance_cash', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->string('name');
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->unsignedBigInteger('chart_of_account_id')->nullable()->default(null);
            $table->timestamps();

            $table->unique('uuid');
            $table->unique(['name', 'branch_id']);
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
            $table->foreign('chart_of_account_id')->references('id')->on('chart_of_account')->onDelete('set null');
        });
    }
}
