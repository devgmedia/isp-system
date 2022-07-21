<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePreCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pre_customer', function (Blueprint $table) {
            $table->dropColumn('request_pre_survey_date');
            $table->dropColumn('request_survey_date');
            $table->unsignedBigInteger('add_product_to_customer')->nullable()->default(NULL)->after('update_to_prospect_date');
    
            $table->foreign('add_product_to_customer')->references('id')->on('customer')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pre_customer', function($table){
            $table->dropForeign('pre_customer_add_product_to_customer_roreign');
         });
 
         Schema::table('pre_customer', function($table) {
             $table->date('request_pre_survey_date');
             $table->date('request_survey_date');
             $table->dropColumn('add_product_to_customer');
         });
    }
}
