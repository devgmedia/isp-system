<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemAuctionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('item_auction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('item_id')->nullable()->default(null);
            $table->foreign('item_id')->references('id')->on('item')->onDelete('set null');
            $table->date('date_of_auction')->nullable()->default(null);
            $table->float('auction_price', 15, 2)->nullable()->default(null);
            $table->unsignedBigInteger('finance_approved_by')->nullable()->default(null);
            $table->foreign('finance_approved_by')->references('id')->on('supplier')->onDelete('set null');
            $table->datetime('finance_approved_date')->nullable()->default(null);
            $table->string('finance_approved_name')->nullable()->default(null);
            $table->unsignedBigInteger('warehouse_approved_by')->nullable()->default(null);
            $table->foreign('warehouse_approved_by')->references('id')->on('supplier')->onDelete('set null');
            $table->datetime('warehouse_approved_date')->nullable()->default(null);
            $table->string('warehouse_approved_name')->nullable()->default(null);
            $table->string('warehouse_approved_file')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_auction');
    }
}
