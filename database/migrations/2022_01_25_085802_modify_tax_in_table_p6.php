<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTaxInTableP6 extends Migration
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
            $table->date('date')->nullable()->default(null);
            $table->date('invoice_date')->nullable()->default(null);
            $table->string('supplier_name')->nullable()->default(null);
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
