<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCashierInTableP7 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashier_in', function (Blueprint $table) {
            $table->string('category_name')->nullable()->default(null);
        });

        Schema::table('cashier_in', function (Blueprint $table) {
            $table->unsignedBigInteger('chart_of_account_title_id')->nullable()->default(null);
            $table->foreign('chart_of_account_title_id')->references('id')->on('chart_of_account_title')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cashier_in', function (Blueprint $table) {
            //
        });
    }
}
