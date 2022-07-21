<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeBankAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_bank_account', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bank_id')->nullable()->default(NULL);
            $table->string('number')->unique();
            $table->string('on_behalf_of')->nullable()->default(NULL);
            $table->unsignedBigInteger('employee_id')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('bank_id')->references('id')->on('bank')->onDelete('set null');
            $table->foreign('employee_id')->references('id')->on('employee')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_bank_account');
    }
}
