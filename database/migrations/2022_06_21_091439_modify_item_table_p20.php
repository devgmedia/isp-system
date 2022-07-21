<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyItemTableP20 extends Migration
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
            $table->dropForeign('item_pic_foreign');
        });

        Schema::table('item', function (Blueprint $table) {
            $table->dropColumn('pic');
        });

        Schema::table('item', function (Blueprint $table) {
            $table->unsignedBigInteger('pic')->nullable()->default(null);
            $table->foreign('pic')->references('id')->on('division')->onDelete('set null');
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
