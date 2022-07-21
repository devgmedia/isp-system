<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceTableP6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->string('payer_postal_code')->nullable()->default(null);
            $table->string('payer_phone_number')->nullable()->default(null);
            $table->string('payer_fax')->nullable()->default(null);
            $table->string('payer_email')->nullable()->default(null);
            $table->unsignedBigInteger('brand_id')->nullable()->default(null);

            $table->foreign('brand_id')->references('id')->on('ar_invoice_brand')->onDelete('set null');
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
        });

        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->dropColumn([
                'payer_postal_code',
                'payer_phone_number',
                'payer_fax',
                'payer_email',
                'brand_id',
            ]);
        });
    }
}
