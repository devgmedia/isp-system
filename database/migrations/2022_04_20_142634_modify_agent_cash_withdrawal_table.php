<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyAgentCashWithdrawalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agent_cash_withdrawal', function (Blueprint $table) {
            $table->string('proof_of_transaction')->nullable()->default(null);
            $table->string('agent_name')->nullable()->default(null);
            $table->string('agent_alias_name')->nullable()->default(null);

            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->foreign('branch_id')->references('id')->on('agent')->onDelete('set null');
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
