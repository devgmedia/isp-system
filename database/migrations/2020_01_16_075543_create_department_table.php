<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('division_id')->nullable()->default(null);
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->unsignedBigInteger('regional_id')->nullable()->default(null);
            $table->unsignedBigInteger('company_id')->nullable()->default(null);
            $table->timestamps();

            $table->unique(['name', 'branch_id']);
            $table->foreign('division_id')->references('id')->on('division')->onDelete('set null');
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
            $table->foreign('regional_id')->references('id')->on('regional')->onDelete('set null');
            $table->foreign('company_id')->references('id')->on('company')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('department');
    }
}
