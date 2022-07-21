<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceTableP7 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->dropForeign('ar_invoice_brand_id_foreign');
        });

        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->dropColumn([
                'brand_id',
            ]);
        });

        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->string('name')->nullable()->default(null);

            $table->unsignedBigInteger('brand_id')->nullable()->default(null);
            $table->string('brand_name')->nullable()->default(null);

            $table->string('receiver_name')->nullable()->default(null);
            $table->string('receiver_address')->nullable()->default(null);
            $table->string('receiver_postal_code')->nullable()->default(null);
            $table->string('receiver_phone_number')->nullable()->default(null);
            $table->string('receiver_fax')->nullable()->default(null);
            $table->string('receiver_email')->nullable()->default(null);

            $table->unsignedBigInteger('previous')->nullable()->default(null);
            $table->float('previous_price', 15, 2)->nullable()->default(null);
            $table->float('previous_discount', 15, 2)->nullable()->default(null);
            $table->float('previous_price_after_discount', 15, 2)->nullable()->default(null);
            $table->float('previous_ppn', 15, 2)->nullable()->default(null);
            $table->float('previous_dpp', 15, 2)->nullable()->default(null);
            $table->float('previous_price_with_ppn', 15, 2)->nullable()->default(null);
            $table->float('previous_total', 15, 2)->nullable()->default(null);
            $table->boolean('previous_paid')->nullable()->default(null);

            $table->foreign('brand_id')->references('id')->on('product_brand')->onDelete('set null');
            $table->foreign('previous')->references('id')->on('ar_invoice')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->dropForeign('ar_invoice_brand_id_foreign');
            $table->dropForeign('ar_invoice_previous_foreign');
        });

        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->dropColumn([
                'name',

                'brand_id',
                'brand_name',

                'receiver_name',
                'receiver_address',
                'receiver_postal_code',
                'receiver_phone_number',
                'receiver_fax',
                'receiver_email',

                'previous',
                'previous_price',
                'previous_discount',
                'previous_price_after_discount',
                'previous_ppn',
                'previous_dpp',
                'previous_price_with_ppn',
                'previous_total',
                'previous_paid',
            ]);
        });
    }
}
