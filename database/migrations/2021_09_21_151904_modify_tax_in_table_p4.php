<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTaxInTableP4 extends Migration
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
            $table->tinyInteger('masa')->nullable()->default(null);
            $table->float('pph_pasal_26', 15, 2)->nullable(false)->default(0);
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
