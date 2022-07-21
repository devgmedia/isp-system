<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePreCustomerProductAdditionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pre_customer_product_additional', function($table) {
            $table->dropColumn('sid');
            $table->dropColumn('registration_date');
            $table->boolean('adjusted_price')->nullable()->default(NULL)->after('media_vendor_id');
            $table->unsignedInteger('special_price')->nullable()->default(NULL)->after('adjusted_price');
            $table->boolean('adjusted_quantity')->nullable()->default(NULL)->after('special_price');
            $table->unsignedtinyInteger('quantity')->nullable()->default(NULL)->after('adjusted_quantity');
            
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pre_customer_product_additional', function($table) {
            $table->string('sid');
            $table->date('registration_date');
            $table->dropColumn('adjusted_price');
            $table->dropColumn('special_price');
            $table->dropColumn('adjusted_quantity');
            $table->dropColumn('quantity');
        });
    }
}
