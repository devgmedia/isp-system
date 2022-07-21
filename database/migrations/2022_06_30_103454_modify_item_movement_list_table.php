<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyItemMovementListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('item_movement_list', function (Blueprint $table) {
            $table->renameColumn('pic', 'to_pic');
            $table->unsignedBigInteger('from_pic')->nullable()->default(null);
            $table->foreign('from_pic')->references('id')->on('division')->onDelete('set null');

            $table->renameColumn('item_class_id', 'to_item_class_id');
            $table->unsignedBigInteger('from_item_class_id')->nullable()->default(null);
            $table->foreign('from_item_class_id')->references('id')->on('item_class')->onDelete('set null');
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
