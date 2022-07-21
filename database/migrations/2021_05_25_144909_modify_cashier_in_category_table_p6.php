<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCashierInCategoryTableP6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashier_in_category', function (Blueprint $table) {
            $table->unsignedBigInteger('accounting_menu_id')->nullable()->default(null);
            $table->foreign('accounting_menu_id')->references('id')->on('accounting_menu')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cashier_in_category', function (Blueprint $table) {
        });
    }
}
