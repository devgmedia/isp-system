<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyItemAuctionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('item_auction', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->default(null);
            $table->foreign('created_by')->references('id')->on('user')->onDelete('set null');
            $table->string('created_name')->nullable()->default(null);
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
