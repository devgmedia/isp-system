<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCashierInTableP10 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('cashier_in', function (Blueprint $table) {
            $table->dropForeign('cashier_in_memo_settlement_id_foreign');
        });

        Schema::table('cashier_in', function (Blueprint $table) {
            $table->dropColumn('memo_settlement_id');
        });

        Schema::table('cashier_in', function (Blueprint $table) {
            $table->unsignedBigInteger('memo_to')->nullable()->default(null);
            $table->foreign('memo_to')->references('id')->on('branch')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
