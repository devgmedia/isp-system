<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentCashWithdrawalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_cash_withdrawal', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('agent_id')->nullable()->default(null);
            $table->foreign('agent_id')->references('id')->on('agent')->onDelete('set null');

            $table->date('date');
            $table->unsignedInteger('money')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent_cash_withdrawal');
    }
}
