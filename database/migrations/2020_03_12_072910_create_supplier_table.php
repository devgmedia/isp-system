<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('address');
            $table->unsignedBigInteger('created')->nullable()->default(NULL);
            $table->date('created_date')->nullable()->default(NULL);
            $table->unsignedBigInteger('director_of_operations')->nullable()->default(NULL);
            $table->date('director_of_operations_verified_date')->nullable()->default(NULL);
            $table->unsignedBigInteger('branch_id')->nullable()->default(NULL);
            $table->timestamps();

            $table->unique(['name', 'branch_id']);
            $table->foreign('created')->references('id')->on('user')->onDelete('set null');
            $table->foreign('director_of_operations')->references('id')->on('user')->onDelete('set null');
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
        Schema::dropIfExists('supplier');
    }
}
