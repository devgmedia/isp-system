<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameCustomerAlternativeEmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('customer_alternative_email', 'customer_email');

        Schema::table('customer_email', function (Blueprint $table) {
            $table->dropForeign('customer_alternative_email_customer_id_foreign');
        });

        Schema::table('customer_email', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('customer_alternative_email', 'customer_email');

        Schema::table('customer_email', function (Blueprint $table) {
            $table->dropForeign('customer_alternative_email_customer_id_foreign');
        });

        Schema::table('customer_email', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('set null');
        });
    }
}
