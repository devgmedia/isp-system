<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceSchemeCustomerProductAdditionalTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('ar_invoice_scheme_customer_product_additional', function (Blueprint $table) {
            $table->unique('customer_product_additional_id', 'ar_inv_sch_cus_pro_add_cus_pro_add_id_unqiue');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_invoice_scheme_customer_product_additional', function (Blueprint $table) {
            $table->dropUnique('ar_inv_sch_cus_pro_add_cus_pro_add_id_unqiue');
        });
    }
}
