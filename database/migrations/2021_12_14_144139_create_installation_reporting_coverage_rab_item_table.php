<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallationReportingCoverageRabItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('installation_reporting_coverage_rab_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('installation_reporting_coverage_id')->nullable()->default(null);
            $table->unsignedBigInteger('brand_id')->nullable()->default(null);
            $table->unsignedBigInteger('brand_product_id')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->string('brand_name')->nullable()->default(null);
            $table->string('brand_product_name')->nullable()->default(null);
            $table->unsignedSmallInteger('quantity')->nullable()->default(null);
            $table->unsignedBigInteger('unit_id')->nullable()->default(null);
            $table->unsignedBigInteger('category_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('installation_reporting_coverage_id', 'ins_rept_cove_id_foreign')->references('id')->on('installation_reporting_coverage')->onDelete('set null');
            $table->foreign('brand_id')->references('id')->on('item_brand')->onDelete('set null');
            $table->foreign('brand_product_id', 'brnd_prod_rab_id_foreign')->references('id')->on('item_brand_product')->onDelete('set null');
            $table->foreign('unit_id')->references('id')->on('installation_reporting_coverage_rab_item_unit')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('installation_reporting_coverage_rab_category')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('installation_reporting_coverage_rab_item');
    }
}
