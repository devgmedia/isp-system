<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomerTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->dropForeign('customer_approved_by_marketing_manager_id_foreign');
        });

        Schema::table('customer', function (Blueprint $table) {
            $table->dropColumn('approved_by_marketing_manager');
            $table->dropColumn('approved_by_marketing_manager_id');
            $table->dropColumn('approved_by_marketing_manager_date');
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
            $table->boolen('approved_by_marketing_manager')->nullable()->default(false);
            $table->unsignedBigInteger('approved_by_marketing_manager_id')->nullable()->default(null);
            $table->date('approved_by_marketing_manager_date')->nullable()->default(null);

            $table->foreign('approved_by_marketing_manager_id')->references('id')->on('employee')->onDelete('set null');
        });
    }
}
