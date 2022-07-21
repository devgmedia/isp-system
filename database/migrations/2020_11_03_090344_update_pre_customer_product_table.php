<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class UpdatePreCustomerProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('pre_customer_product', function ($table) {
            $table->dropColumn('sid');
            $table->dropColumn('registration_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pre_customer_product', function ($table) {
            $table->string('sid');
            $table->date('registration_date');
        });
    }
}
