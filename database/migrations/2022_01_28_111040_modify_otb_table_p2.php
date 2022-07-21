<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyOtbTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('otb', function (Blueprint $table) {
            $table->dropForeign('otb_pon_id_foreign');
            $table->dropColumn('pon_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('otb', function (Blueprint $table) {
            $table->unsignedBigInteger('pon_id')->nullable()->default(null);

            $table->foreign('pon_id')->references('id')->on('pon')->onDelete('set null');
        });
    }
}
