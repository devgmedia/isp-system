<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTaxInTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('tax_in', function (Blueprint $table) {
            $table->float('pph_pasal_21', 15, 2)->nullable(false)->default(0)->change();
            $table->float('pph_pasal_23', 15, 2)->nullable(false)->default(0)->change();
            $table->float('pph_pasal_4_ayat_2', 15, 2)->nullable(false)->default(0)->change();
            $table->float('ppn', 15, 2)->nullable(false)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tax_in', function (Blueprint $table) {
            //
        });
    }
}
