<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyItemTableP17 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item', function (Blueprint $table) {
            $table->renameColumn('expiration_date', 'lifetime_end_date');
            $table->renameColumn('purchase_barcodes', 'purchase_barcode');

            $table->renameColumn('from_ownership_branch_id', 'ownership_branch_id');
            $table->renameColumn('from_ownership_regional_id', 'ownership_regional_id');
            $table->renameColumn('from_ownership_company_id', 'ownership_company_id');
            $table->renameColumn('from_ownership_customer_id', 'ownership_customer_id');
            $table->renameColumn('from_ownership_employee_id', 'ownership_employee_id');

            $table->renameColumn('from_location_branch_id', 'location_branch_id');
            $table->renameColumn('from_location_regional_id', 'location_regional_id');
            $table->renameColumn('from_location_company_id', 'location_company_id');
            $table->renameColumn('from_location_customer_id', 'location_customer_id');
            $table->renameColumn('from_location_employee_id', 'location_employee_id');

            $table->renameColumn('long_warranty', 'warranty_priod');
            $table->renameColumn('long_expiration', 'lifetime_priod');

            $table->unsignedBigInteger('pic')->nullable()->default(null);
            $table->foreign('pic')->references('id')->on('spm')->onDelete('set null');

            $table->boolean('auction')->nullable()->default(null);
            $table->float('auction_price', 15, 2);
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
