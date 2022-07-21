<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallationReportingCoverageBoqItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installation_reporting_coverage_boq_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('installation_reporting_coverage_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('brand_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('brand_product_id')->nullable()->default(NULL);
            $table->string('name')->nullable()->default(NULL);
            $table->string('brand_name')->nullable()->default(NULL);
            $table->string('brand_product_name')->nullable()->default(NULL);
            $table->unsignedSmallInteger('quantity')->nullable()->default(NULL);
            $table->unsignedBigInteger('unit_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('category_id')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('installation_reporting_coverage_id','ins_cove_id_foreign')->references('id')->on('installation_reporting_coverage')->onDelete('set null');
            $table->foreign('brand_id')->references('id')->on('item_brand')->onDelete('set null');
            $table->foreign('brand_product_id','brnd_prod_boq_id_foreign')->references('id')->on('item_brand_product')->onDelete('set null');
            $table->foreign('unit_id')->references('id')->on('installation_reporting_coverage_boq_item_unit')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('installation_reporting_coverage_boq_category')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('installation_reporting_coverage_boq_item');
    }
}
