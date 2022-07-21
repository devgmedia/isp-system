<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('purchase_request', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->nullable()->default(null)->unique();
            $table->date('date');
            $table->string('about');
            $table->unsignedBigInteger('created')->nullable()->default(null);
            $table->date('created_date')->nullable()->default(null);
            $table->unsignedBigInteger('finance_manager')->nullable()->default(null);
            $table->string('finance_manager_name')->nullable()->default(null);
            $table->date('finance_manager_approved_date')->nullable()->default(null);
            $table->unsignedBigInteger('director_of_operations')->nullable()->default(null);
            $table->string('director_of_operations_name')->nullable()->default(null);
            $table->date('director_of_operations_approved_date')->nullable()->default(null);
            $table->unsignedBigInteger('commissioner')->nullable()->default(null);
            $table->string('commissioner_name')->nullable()->default(null);
            $table->date('commissioner_approved_date')->nullable()->default(null);
            $table->unsignedInteger('total')->nullable()->default(null);
            $table->unsignedBigInteger('branch_id')->nullable()->defalut(null);
            $table->timestamps();

            $table->foreign('finance_manager')->references('id')->on('user')->onDelete('set null');
            $table->foreign('director_of_operations')->references('id')->on('user')->onDelete('set null');
            $table->foreign('commissioner')->references('id')->on('user')->onDelete('set null');
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
        Schema::dropIfExists('purchase_request');
    }
}
