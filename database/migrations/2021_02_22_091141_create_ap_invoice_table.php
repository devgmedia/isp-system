<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('ap_invoice', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('supplier_id')->nullable()->default(null);
            $table->string('number');
            $table->string('purchase_order_number')->nullable()->default(null);
            $table->date('date');
            $table->date('due_date');
            $table->string('name');
            $table->unsignedInteger('retention')->nullable()->default(0);
            $table->unsignedInteger('stamp_duty')->nullable()->default(0);
            $table->unsignedInteger('discount')->nullable()->default(0);
            $table->unsignedInteger('pph_pasal_23')->nullable()->default(0);
            $table->unsignedInteger('pph_pasal_4_ayat_2')->nullable()->default(0);
            $table->float('tax', 15, 2);
            $table->float('tax_base', 15, 2);
            $table->float('total', 15, 2);
            $table->unsignedInteger('paid_total')->nullable()->default(0);
            $table->boolean('paid')->nullable()->default(null);
            $table->datetime('paid_at')->nullable()->default(null);
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('supplier_id')->on('supplier')->references('id')->onDelete('set null');
            $table->foreign('branch_id')->on('branch')->references('id')->onDelete('set null');

            $table->unique('number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ap_invoice');
    }
}
