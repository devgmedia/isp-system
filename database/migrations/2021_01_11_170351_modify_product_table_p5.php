<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyProductTableP5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn('router_host');
            $table->dropColumn('router_port');
            $table->dropColumn('router_user');
            $table->dropColumn('router_pass');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->string('router_host');
            $table->unsignedSmallInteger('router_port');
            $table->string('router_user');
            $table->string('router_pass');
        });
    }
}
