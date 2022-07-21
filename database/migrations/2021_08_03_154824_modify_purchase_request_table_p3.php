<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPurchaseRequestTableP3 extends Migration
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
            $table->dropColumn('name');
            $table->unsignedBigInteger('currency_id')->nullable()->default(null);
            $table->unsignedBigInteger('payment_method_id')->nullable()->default(null);
            $table->unsignedBigInteger('shipping_address_id')->nullable()->default(null);
            $table->date('shipping_estimates');
            $table->unsignedBigInteger('term_of_delivery_id')->nullable()->default(null);
            $table->unsignedBigInteger('term_of_payment_id')->nullable()->default(null);
            $table->float('diskon', 15, 2)->nullable()->default(null);
            $table->float('ppn', 15, 2)->nullable()->default(null);
            $table->date('term_of_payment_date');
            $table->text('term_of_payment_description')->nullable()->default(null);
            $table->string('offer_document')->nullable()->default(null);

            $table->foreign('currency_id')->references('id')->on('purchase_request_currency')->onDelete('set null');
            $table->foreign('payment_method_id')->references('id')->on('purchase_request_payment_method')->onDelete('set null');
            $table->foreign('shipping_address_id')->references('id')->on('purchase_request_shipping_address')->onDelete('set null');
            $table->foreign('term_of_delivery_id')->references('id')->on('purchase_request_term_of_delivery')->onDelete('set null');
            $table->foreign('term_of_payment_id')->references('id')->on('purchase_request_term_of_payment')->onDelete('set null');
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
            $table->dropForeign('purchase_request_currency_id_foreign');
            $table->dropForeign('purchase_request_payment_method_id_foreign');
            $table->dropForeign('purchase_request_shipping_address_id_foreign');
            $table->dropForeign('purchase_request_term_of_delivery_id_foreign');
            $table->dropForeign('purchase_request_term_of_payment_id_foreign');
        });

        Schema::table('purchase_request', function (Blueprint $table) {
            $table->string('name');
            $table->dropColumn('currency_id');
            $table->dropColumn('payment_method_id');
            $table->dropColumn('shipping_address_id');
            $table->dropColumn('shipping_estimates');
            $table->dropColumn('term_of_delivery_id');
            $table->dropColumn('term_of_payment_id');
            $table->dropColumn('diskon');
            $table->dropColumn('ppn');
            $table->dropColumn('term_of_payment_date');
            $table->dropColumn('term_of_payment_description');
            $table->dropColumn('offer_document');
        });
    }
}
