<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UdpateCustomerProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_product', function (Blueprint $table) {
            $table->dropForeign('customer_product_customer_id_foreign');
        });

        Schema::table('customer_product', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('set null');

            $table->string('sid')->nullable(false)->change();
            $table->date('service_start_date')->nullable()->default(null);
            $table->date('service_end_date')->nullable()->default(null);
            $table->date('service_date')->nullable()->default(null);
            $table->date('billing_start_date')->nullable()->default(null);
            $table->date('billing_end_date')->nullable()->default(null);
            $table->date('billing_date')->nullable()->default(null);
            
            $table->unsignedBigInteger('dependency')->nullable()->default(null);
            $table->foreign('dependency')->references('id')->on('customer_product')->onDelete('set null');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_product', function (Blueprint $table) {
            $table->dropForeign('customer_product_customer_id_foreign');
        });

        Schema::table('customer_product', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('cascade');

            $table->string('sid')->nullable()->default(null)->change();
            $table->dropColumn([
                'service_start_date',
                'service_end_date',
                'service_date',
                'billing_start_date',
                'billing_end_date',
                'billing_date',
            ]);

            $table->dropForeign('customer_product_dependency_foreign');
            $table->dropColumn('dependency');
        }); 
    }
}
