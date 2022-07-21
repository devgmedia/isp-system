<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyApInvoiceItemPoCategoryTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('ap_invoice_item_po_category', function (Blueprint $table) {
            $table->dropUnique('ap_invoice_item_category_name_unique');
            $table->unique(['name', 'chart_of_account_title_id'], 'ap_inv_ite_po_cat_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
