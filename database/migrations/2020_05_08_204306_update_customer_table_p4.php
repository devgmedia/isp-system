<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCustomerTableP4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->dropColumn('referrar_used_for_discount');
            $table->boolean('referrer_used_for_discount')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->boolean('referrar_used_for_discount')->nullable()->default(null);
            $table->dropColumn('referrer_used_for_discount');
        });
    }
}
