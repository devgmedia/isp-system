<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePurchaseRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('purchase_request', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->default(null)->after('branch_id');
            $table->unsignedBigInteger('customer_id')->nullable()->default(null)->after('company_id');

            $table->foreign('company_id')->references('id')->on('company')->onDelete('set null');
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
        Schema::table('purchase_request', function (Blueprint $table) {
            $table->dropForeign('purchase_request_company_id_foreign');
            $table->dropForeign('purchase_request_customer_id_foreign');

            $table->dropColumn(['company_id', 'customer_id']);
        });
    }
}
