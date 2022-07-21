<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyProductTableP6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropForeign('product_billing_bank_id_foreign');
            $table->dropForeign('product_billing_receiver_foreign');
        });

        Schema::table('product', function (Blueprint $table) {
            $table->boolean('bandwidth_can_be_adjusted')->nullable()->default(false);
            $table->dropColumn('billing_bank_id');
            $table->dropColumn('billing_bank_account_number');
            $table->dropColumn('billing_bank_account_on_behalf_of');
            $table->dropColumn('billing_receiver');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn('bandwidth_can_be_adjusted');
            $table->unsignedBigInteger('billing_bank_id')->nullable()->default(null);
            $table->string('billing_bank_account_number')->nullable()->default(null);
            $table->string('billing_bank_account_on_behalf_of')->nullable()->default(null);
            $table->string('billing_receiver')->nullable()->default(null);
        });
    }
}
