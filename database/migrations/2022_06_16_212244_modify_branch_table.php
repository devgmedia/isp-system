<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyBranchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('branch', function (Blueprint $table) {
            $table->string('agent_fee_pic')->nullable()->default(null);
            $table->string('agent_fee_division')->nullable()->default(null);
            $table->string('agent_fee_finance')->nullable()->default(null);
            $table->string('agent_fee_director')->nullable()->default(null);
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
