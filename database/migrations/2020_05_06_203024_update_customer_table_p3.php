<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCustomerTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->dropColumn('previous_isp_bandwidth_type');
            
            $table->unsignedBigInteger('previous_isp_bandwidth_type_id')->nullable()->default(null);
            $table->foreign('previous_isp_bandwidth_type_id')->references('id')->on('bandwidth_type')->onDelete('set null');
            
            $table->unsignedBigInteger('referrer')->nullable()->default(null);
            $table->foreign('referrer')->references('id')->on('customer')->onDelete('set null');

            $table->boolean('referrar_used_for_discount')->nullable()->default(false);
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->enum('previous_isp_bandwidth_type', ['up to', 'dedicated'])->nullable()->default(NULL);
            
            $table->dropForeign('customer_previous_isp_bandwidth_type_id_foreign');
            $table->dropColumn('previous_isp_bandwidth_type_id');
            
            $table->dropForeign('customer_referrer_foreign');
            $table->dropColumn('referrer');

            $table->dropColumn('referrer_used_for_discount');
        });         
    }
}
