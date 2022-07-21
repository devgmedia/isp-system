<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPerCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('pre_customer', function (Blueprint $table) {
            $table->dropForeign('pre_customer_approved_by_foreign');
        });

        Schema::table('pre_customer', function (Blueprint $table) {
            $table->dropColumn('approved_by');
            $table->dropColumn('approved_date');
            $table->dropColumn('approved_name');
            $table->dropColumn('cancel');
            $table->dropColumn('cancel_at');
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
