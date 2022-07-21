<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyItemReturnTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_return', function (Blueprint $table) {
            $table->unsignedBigInteger('spm_id')->nullable()->default(null);
            $table->foreign('spm_id')->references('id')->on('spm')->onDelete('set null');
            $table->string('number_invoice')->nullable()->default(null);
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
