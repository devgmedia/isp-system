<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomerProductTableP45 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('customer_product', function (Blueprint $table) {
            $table->string('tax_rounding')->nullable()->default(null);
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
