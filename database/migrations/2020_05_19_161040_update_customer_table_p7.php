<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCustomerTableP7 extends Migration
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
            $table->date('installation_date')->nullable()->default(null);
            $table->dropColumn([
                'bill_activated',
                'active',
            ]);
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
            $table->dropColumn([
                'installation_date',
            ]);
            $table->boolean('bill_activated')->nullable()->default(false);
            $table->boolean('active')->nullable()->default(false);
        });
    }
}
