<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('purchase_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('number')->nullable()->default(null)->unique();
            $table->date('date');
            $table->string('about');
            $table->unsignedBigInteger('created_by')->nullable()->default(null);
            $table->string('created_name')->nullable()->default(null);
            $table->date('created_date')->nullable()->default(null);
            $table->unsignedBigInteger('finance_approved_by')->nullable()->default(null);
            $table->date('finance_approved_date')->nullable()->default(null);
            $table->string('finance_approved_name')->nullable()->default(null);
            $table->unsignedBigInteger('director_approved_by')->nullable()->default(null);
            $table->date('director_approved_date')->nullable()->default(null);
            $table->string('director_approved_name')->nullable()->default(null);
            $table->unsignedInteger('total')->nullable()->default(null);
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_order');
    }
}
