<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('ar_invoice_customer', function (Blueprint $table) {
            $table->unsignedBigInteger('ar_invoice_scheme_customer_id')->nullable()->default(null);

            $table->string('customer_cid');
            $table->string('customer_name');
            $table->unsignedBigInteger('customer_province_id')->nullable()->default(null);
            $table->string('customer_province_name')->nullable()->default(null);
            $table->unsignedBigInteger('customer_district_id')->nullable()->default(null);
            $table->string('customer_district_name')->nullable()->default(null);
            $table->unsignedBigInteger('customer_sub_district_id')->nullable()->default(null);
            $table->string('customer_sub_district_name')->nullable()->default(null);
            $table->unsignedBigInteger('customer_village_id')->nullable()->default(null);
            $table->string('customer_village_name')->nullable()->default(null);
            $table->string('customer_address')->nullable()->default(null);

            $table->foreign('ar_invoice_scheme_customer_id')->references('id')->on('ar_invoice_scheme_customer')->onDelete('set null');

            $table->foreign('customer_province_id')->references('id')->on('province')->onDelete('set null');
            $table->foreign('customer_district_id')->references('id')->on('district')->onDelete('set null');
            $table->foreign('customer_sub_district_id')->references('id')->on('sub_district')->onDelete('set null');
            $table->foreign('customer_village_id')->references('id')->on('village')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_invoice_customer', function (Blueprint $table) {
            $table->dropForeign('ar_invoice_customer_ar_invoice_scheme_customer_id_foreign');

            $table->dropForeign('ar_invoice_customer_customer_province_id_foreign');
            $table->dropForeign('ar_invoice_customer_customer_district_id_foreign');
            $table->dropForeign('ar_invoice_customer_customer_sub_district_id_foreign');
            $table->dropForeign('ar_invoice_customer_customer_village_id_foreign');
        });

        Schema::table('ar_invoice_customer', function (Blueprint $table) {
            $table->dropColumn([
                'ar_invoice_scheme_customer_id',

                'customer_cid',
                'customer_name',
                'customer_province_id',
                'customer_province_name',
                'customer_district_id',
                'customer_district_name',
                'customer_sub_district_id',
                'customer_sub_district_name',
                'customer_village_id',
                'customer_village_name',
            ]);
        });
    }
}
