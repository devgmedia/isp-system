<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPreCustomerTableP4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pre_customer', function (Blueprint $table) {
            $table->unsignedBigInteger('approved_by')->nullable()->default(null);
            $table->date('approved_date')->nullable()->default(null);
            $table->string('approved_name')->nullable()->default(null);

            $table->foreign('approved_by')->references('id')->on('employee')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
