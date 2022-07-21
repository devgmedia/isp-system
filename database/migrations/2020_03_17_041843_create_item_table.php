<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->unique();
            $table->unsignedBigInteger('brand_id')->nullable()->default(null);
            $table->unsignedBigInteger('brand_product_id')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->string('barcode')->nullable()->default(null)->unique();
            $table->string('mac_address')->nullable()->default(null)->unique();
            $table->unsignedInteger('purchase_price')->nullable()->default(null); // tidak perlu jika sudah berelasi dengan invoice item
            $table->date('date_of_purchase')->nullable()->default(null);
            $table->date('warranty_date_end')->nullable()->default(null);
            $table->unsignedBigInteger('invoice_item_id')->nullable()->default(null);
            $table->string('invoice_number')->nullable()->default(null); // tidak perlu jika sudah berelasi dengan invoice
            $table->string('serial_number')->nullable()->default(null);
            $table->unsignedBigInteger('supplier_id')->nullable()->default(null);
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->timestamps();

            // // $table->foreign('invoice_item_id')->references('id')->on('invoice_item')->onDelete('set null');
            $table->foreign('brand_product_id')->references('id')->on('item_brand_product')->onDelete('set null');
            $table->foreign('brand_id')->references('id')->on('item_brand')->onDelete('set null');
            $table->foreign('supplier_id')->references('id')->on('supplier')->onDelete('set null');
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
        Schema::dropIfExists('item');
    }
}
