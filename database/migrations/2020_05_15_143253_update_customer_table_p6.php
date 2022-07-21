<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCustomerTableP6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->string('postal_code')->nullable()->default(null);
            $table->string('fax')->nullable()->default(null);
            $table->boolean('bill_activated')->nullable()->default(false);
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
                'postal_code',
                'fax',
                'bill_activated',
            ]);
        });
    }
}
