<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomerEmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('customer_email', function (Blueprint $table) {
            $table->string('uuid')->nullable()->default(null);

            $table->boolean('verified')->nullable()->default(null);
            $table->datetime('verified_at')->nullable()->default(null);

            $table->datetime('verification_email_sent_at')->nullable()->default(null);
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
