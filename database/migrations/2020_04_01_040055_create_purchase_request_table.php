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
    public function up()
    {
        Schema::create('purchase_request', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->nullable()->default(NULL)->unique();
            $table->date('date');
            $table->string('about');
            $table->unsignedBigInteger('created')->nullable()->default(NULL);
            $table->date('created_date')->nullable()->default(NULL);
            $table->unsignedBigInteger('finance_manager')->nullable()->default(NULL);
            $table->string('finance_manager_name')->nullable()->default(NULL);
            $table->date('finance_manager_approved_date')->nullable()->default(NULL);
            $table->unsignedBigInteger('director_of_operations')->nullable()->default(NULL);
            $table->string('director_of_operations_name')->nullable()->default(NULL);
            $table->date('director_of_operations_approved_date')->nullable()->default(NULL);
            $table->unsignedBigInteger('commissioner')->nullable()->default(NULL);
            $table->string('commissioner_name')->nullable()->default(NULL);
            $table->date('commissioner_approved_date')->nullable()->default(NULL);
            $table->unsignedInteger('total')->nullable()->default(NULL);
            $table->unsignedBigInteger('branch_id')->nullable()->defalut(NULL);
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
