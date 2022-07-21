<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyItemOpnameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('item_opname', function (Blueprint $table) {
            $table->dropForeign('item_opname_item_type_id_foreign');
        });

        Schema::table('item_opname', function (Blueprint $table) {
            $table->dropColumn('item_type_id');
        });

        Schema::table('item_opname', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id')->nullable()->default(null);
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
