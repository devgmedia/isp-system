<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyProductRouterTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_router', function (Blueprint $table) {
            $table->dropColumn('os');

            $table->unsignedBigInteger('os_id')->nullable()->default(null);
            $table->foreign('os_id')->references('id')->on('product_router_os')->onDelete('set null');
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
