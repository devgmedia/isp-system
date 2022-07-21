<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceV2TableP3 extends Migration
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
            $table->unsignedBigInteger('created_by')->nullable()->default(null);
            $table->unsignedBigInteger('reference_id')->nullable()->default(null);
            $table->datetime('generated_at')->nullable();

            $table->foreign('created_by')->references('id')->on('user')->onDelete('set null');
            $table->foreign('reference_id')->references('id')->on('ar_invoice_v2')->onDelete('set null');
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
            $table->dropForeign('ar_invoice_v2_created_by_foreign');
            $table->dropForeign('ar_invoice_v2_reference_id_foreign');

            $table->dropColumn('created_by');
            $table->dropColumn('reference_id');
            $table->dropColumn('generated_at');
        });
    }
}
