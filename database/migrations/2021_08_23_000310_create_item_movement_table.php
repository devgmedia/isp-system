<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemMovementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('item_movement', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date')->nullable()->default(null);
            $table->time('time')->nullable()->default(null);
            $table->unsignedBigInteger('created_by')->nullable()->default(null);
            $table->string('created_name')->nullable()->default(null);
            $table->date('created_date')->nullable()->default(null);
            $table->unsignedBigInteger('warehouse_approved_by')->nullable()->default(null);
            $table->string('warehouse_approved_name')->nullable()->default(null);
            $table->date('warehouse_approved_date')->nullable()->default(null);
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
        Schema::dropIfExists('item_movement');
    }
}
