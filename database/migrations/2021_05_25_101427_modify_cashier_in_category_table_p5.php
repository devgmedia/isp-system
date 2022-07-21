<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCashierInCategoryTableP5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashier_in_category', function (Blueprint $table) {
            $table->dropForeign('cashier_in_category_branch_id_foreign');
        });

        Schema::table('cashier_in_category', function (Blueprint $table) {
            $table->dropUnique('cashier_in_category_name_branch_id_unique');
        });

        Schema::table('cashier_in_category', function (Blueprint $table) {
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
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
