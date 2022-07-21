<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyAgentNotificationTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('agent_notification', function (Blueprint $table) {
            $table->datetime('date')->nullable()->dafault(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agent_notification', function (Blueprint $table) {
            $table->datetime('date')->change();
        });
    }
}
