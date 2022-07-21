<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChartOfAccountCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chart_of_account_card', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('equation')->nullable()->default(null);
            $table->unsignedBigInteger('chart_of_account_id')->nullable()->default(null);
            $table->timestamps();

            $table->unique(['name', 'chart_of_account_id']);

            $table->foreign('equation')->references('id')->on('accounting_equation')->onDelete('set null');
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
        Schema::dropIfExists('chart_of_account_card');
    }
}
