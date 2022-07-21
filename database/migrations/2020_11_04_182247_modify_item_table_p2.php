<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyItemTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('item', function (Blueprint $table) {
            $table->string('uuid')->unique()->nullable()->default(null);
            $table->dropColumn('number');
            $table->dropColumn('barcode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item', function (Blueprint $table) {
            $table->dropColumn('uuid');
            $table->string('number')->unique()->nullable()->default(null);
            $table->string('barcode')->nullable()->default(null);
        });
    }
}
