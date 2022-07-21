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
            $table->float('latitude', 20, 10)->nullable()->default(null);
            $table->float('longitude', 20, 10)->nullable()->default(null);
            $table->string('timezone')->nullable()->default(null);
            $table->unsignedBigInteger('regional_id')->nullable()->default(null);
            $table->unsignedBigInteger('company_id')->nullable()->default(null);
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
