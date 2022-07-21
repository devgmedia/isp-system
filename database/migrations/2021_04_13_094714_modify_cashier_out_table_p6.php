<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCashierOutTableP6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('cashier_out', function (Blueprint $table) {
            $table->unsignedBigInteger('spm_id')->nullable()->default(null);
            $table->foreign('spm_id')->references('id')->on('spm')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cashier_out', function (Blueprint $table) {
            $table->dropForeign('cashier_out_spm_id_foreign');
        });

        Schema::table('cashier_out', function (Blueprint $table) {
            $table->dropColumn('spm_id');
        });
    }
}
