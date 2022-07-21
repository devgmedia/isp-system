<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPreCustomerAlternativeEmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('pre_customer_alternative_email', function (Blueprint $table) {
            $table->dropForeign('pre_customer_alternative_email_pre_customer_id_foreign');
        });

        Schema::rename('pre_customer_alternative_email', 'pre_customer_email');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pre_customer_alternative_email', function (Blueprint $table) {
            $table->foreign('pre_customer_id')->references('id')->on('pre_customer')->onDelete('set null');
        });

        Schema::rename('pre_customer_email', 'pre_customer_alternative_email');
    }
}
