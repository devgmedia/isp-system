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
    public function up()
    {
        Schema::create('purchase_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('number')->nullable()->default(NULL)->unique();
            $table->date('date');
            $table->string('about');
            $table->unsignedBigInteger('created_by')->nullable()->default(NULL);
            $table->string('created_name')->nullable()->default(NULL);
            $table->date('created_date')->nullable()->default(NULL);;
            $table->unsignedBigInteger('finance_approved_by')->nullable()->default(NULL);;
            $table->date('finance_approved_date')->nullable()->default(NULL);
            $table->string('finance_approved_name')->nullable()->default(NULL);
            $table->unsignedBigInteger('director_approved_by')->nullable()->default(NULL);
            $table->date('director_approved_date')->nullable()->default(NULL);;
            $table->string('director_approved_name')->nullable()->default(NULL);
            $table->unsignedInteger('total')->nullable()->default(NULL);
            $table->unsignedBigInteger('branch_id')->nullable()->default(NULL);
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
