<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPreCustomerTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pre_customer', function (Blueprint $table) {
            $table->datetime('reqeust_coverage_checking_at')->nullable()->default(null);
            $table->boolean('fo_coverage')->nullable()->default(false);
            $table->boolean('wireless_coverage')->nullable()->default(false);
            $table->datetime('coverage_checking_at')->nullable()->default(null);
            $table->datetime('reqeust_installation_at')->nullable()->default(null);
            $table->date('installation_date')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pre_customer', function (Blueprint $table) {
            $table->dropColumn('reqeust_coverage_checking_at');
            $table->dropColumn('fo_coverage');
            $table->dropColumn('wireless_coverage');
            $table->dropColumn('coverage_checking_at');
            $table->dropColumn('reqeust_installation_at');
            $table->dropColumn('installation_date');
        });
    }
}
