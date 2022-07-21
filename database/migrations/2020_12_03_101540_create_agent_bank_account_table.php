<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentBankAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('agent_bank_account', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bank_id')->nullable()->default(null);
            $table->string('number');
            $table->string('on_behalf_of')->nullable()->default(null);
            $table->unsignedBigInteger('agent_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('bank_id')->references('id')->on('bank')->onDelete('set null');
            $table->foreign('agent_id')->references('id')->on('agent')->onDelete('set null');
            $table->unique('number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent_bank_account');
    }
}
