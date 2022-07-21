<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCashierOutTableP10 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashier_out', function (Blueprint $table) {
            $table->dropForeign('cashier_out_spm_id_foreign');
        });
        
        Schema::table('cashier_out', function (Blueprint $table) {
            $table->dropColumn('spm_id');
            
            $table->unsignedBigInteger('memo_spm_id')->nullable()->default(null);
            $table->foreign('memo_spm_id')->references('id')->on('spm')->onDelete('set null');

            $table->boolean('memo')->nullable()->default(null);
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
