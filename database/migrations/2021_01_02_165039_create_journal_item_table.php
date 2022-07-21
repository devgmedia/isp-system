<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('journal_id')->nullable()->default(null);
            $table->unsignedBigInteger('chart_of_account_id')->nullable()->default(null);
            $table->float('debit', 15, 2);
            $table->float('credit', 15, 2);
            $table->timestamps();

            $table->foreign('journal_id')->references('id')->on('journal')->onDelete('set null');
            $table->foreign('chart_of_account_id')->references('id')->on('chart_of_account')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journal_item');
    }
}
