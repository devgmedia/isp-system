<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->float('discount', 15, 2)->change();
            $table->float('dpp', 15, 2)->change();
            $table->float('ppn', 15, 2)->change();
            $table->float('total', 15, 2)->change();

            $table->unsignedBigInteger('branch_id')->nullable()->default(NULL);
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
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
            $table->unsignedInteger('discount');
            $table->unsignedInteger('dpp');
            $table->unsignedInteger('ppn');
            $table->unsignedInteger('total');

            $table->dropForeign('ar_invoice_branch_id_foreign');
            $table->dropColumn('branch_id');
        });   
    }
}
