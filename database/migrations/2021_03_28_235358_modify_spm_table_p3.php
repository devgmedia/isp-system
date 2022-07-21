<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySpmTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spm', function (Blueprint $table) {
            $table->dropForeign('spm_ap_invoice_id_foreign');
        });

        Schema::table('spm', function (Blueprint $table) {
            $table->dropUnique('spm_ap_invoice_id_unique');
        });
        
        Schema::table('spm', function (Blueprint $table) {
            $table->foreign('ap_invoice_id')->references('id')->on('ap_invoice')->onDelete('set null');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spm', function (Blueprint $table) {
            $table->unique('ap_invoice_id');
        });
    }
}
