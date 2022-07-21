<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceV2TableP1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('ar_invoice_v2', function (Blueprint $table) {
            $table->text('note')->nullable()->after('postpaid');
            $table->date('billing_start_date')->nullable();
            $table->date('billing_end_date')->nullable();
            $table->integer('brand_type')->default(1);
        });

        Schema::table('ar_invoice_detail', function (Blueprint $table) {
            $table->text('note')->nullable()->after('subtotal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_invoice_v2', function (Blueprint $table) {
            $table->dropColumn('note');
            $table->dropColumn('billing_start_date');
            $table->dropColumn('billing_end_date');
            $table->dropColumn('brand_type');
        });

        Schema::table('ar_invoice_detail', function (Blueprint $table) {
            $table->dropColumn('note');
        });
    }
}
