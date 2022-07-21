<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyProductTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->string('router_host')->nullable()->default(null);
            $table->string('router_user')->nullable()->default(null);
            $table->string('router_pass')->nullable()->default(null);
            $table->unsignedSmallInteger('router_port')->nullable()->default(null);
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
            $table->dropColumn('router_host');
            $table->dropColumn('router_user');
            $table->dropColumn('router_pass');
            $table->dropColumn('router_port');
        });
    }
}
