<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('code')->unique();
            $table->float('latitude', 20, 10)->nullable()->default(NULL);
            $table->float('longitude', 20, 10)->nullable()->default(NULL);
            $table->string('timezone')->nullable()->default(NULL);
            $table->unsignedBigInteger('regional_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('company_id')->nullable()->default(NULL);
            $table->timestamps();

            $table->unique(['name', 'company_id']);
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
        Schema::dropIfExists('branch');
    }
}
