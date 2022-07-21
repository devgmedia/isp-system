<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceTableP12 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice', function (Blueprint $table) {
            $table->renameColumn('ppn', 'tax');
            $table->renameColumn('dpp', 'tax_base');

            $table->renameColumn('previous_ppn', 'previous_tax');
            $table->renameColumn('previous_dpp', 'previous_tax_base');
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
            $table->renameColumn('tax', 'ppn');
            $table->renameColumn('tax_base', 'dpp');

            $table->renameColumn('previous_tax', 'previous_ppn');
            $table->renameColumn('previous_tax_base', 'previous_dpp');
        });
    }
}
