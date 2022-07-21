<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyItemReturnTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('item_return', function (Blueprint $table) {
            $table->dropColumn('date_of_purchase')->nullable()->default(null);
            $table->dropColumn('date_of_return')->nullable()->default(null);
        });

        Schema::table('item_return', function (Blueprint $table) {
            $table->date('date_of_purchase')->nullable()->default(null);
            $table->date('date_of_return')->nullable()->default(null);
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
