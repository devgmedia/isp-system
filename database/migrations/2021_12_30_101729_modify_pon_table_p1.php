<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPonTableP1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('pon', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id')->nullable()->default(null);
            $table->renameColumn('device_number', 'rack');
            $table->renameColumn('device_row_number', 'shelf');
            $table->renameColumn('device_row_port_number', 'slot');

            $table->foreign('item_id')->references('id')->on('item')->onDelete('set null');
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
