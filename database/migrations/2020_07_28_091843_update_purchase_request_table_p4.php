<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePurchaseRequestTableP4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('purchase_request', function (Blueprint $table) {
            // drop foreign key
            $table->dropForeign(['purchase_request_category_id']);
            $table->dropForeign(['purchase_request_status_id']);
            $table->dropForeign(['commissioner']);
            $table->dropForeign(['company_id']);
            $table->dropForeign(['customer_id']);

            // drop column
            $table->dropColumn([
                'purchase_request_category_id',
                'purchase_request_status_id',
                'company_id',
                'customer_id',
                'commissioner',
                'commissioner_name',
                'commissioner_approved_date',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_request', function (Blueprint $table) {
            // create column
            $table->unsignedBigInteger('purchase_request_category_id')->nullable()->default(null)->after('about');
            $table->unsignedBigInteger('purchase_request_status_id')->nullable()->default(null)->after('purchase_request_category_id');
            $table->unsignedBigInteger('commissioner')->nullable()->default(null)->after('director_of_operations_approved_date');
            $table->string('commissioner_name')->nullable()->default(null)->after('commissioner');
            $table->date('commissioner_approved_date')->nullable()->default(null)->after('commissioner_name');
            $table->unsignedBigInteger('company_id')->nullable()->default(null)->after('branch_id');
            $table->unsignedBigInteger('customer_id')->nullable()->default(null)->after('company_id');

            // set foreign
            $table->foreign('purchase_request_category_id')->references('id')->on('purchase_request_category')->onDelete('set null');
            $table->foreign('purchase_request_status_id')->references('id')->on('purchase_request_status')->onDelete('set null');
            $table->foreign('commissioner')->references('id')->on('user')->onDelete('set null');
            $table->foreign('company_id')->references('id')->on('company')->onDelete('set null');
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('set null');
        });
    }
}
