<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('agent', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique();
            $table->string('name');
            $table->string('alias_name')->nullable()->default(null);
            $table->date('registration_date');

            $table->unsignedBigInteger('province_id')->nullable()->default(null);
            $table->foreign('province_id')->references('id')->on('province')->onDelete('set null');

            $table->unsignedBigInteger('district_id')->nullable()->default(null);
            $table->foreign('district_id')->references('id')->on('district')->onDelete('set null');

            $table->unsignedBigInteger('sub_district_id')->nullable()->default(null);
            $table->foreign('sub_district_id')->references('id')->on('sub_district')->onDelete('set null');

            $table->unsignedBigInteger('village_id')->nullable()->default(null);
            $table->foreign('village_id')->references('id')->on('village')->onDelete('set null');

            $table->string('address')->nullable()->default(null);
            $table->string('postal_code')->nullable()->default(null);
            $table->string('fax')->nullable()->default(null);
            $table->unsignedInteger('money')->default(0);
            $table->string('email')->nullable()->default(null);
            $table->string('identity_card')->nullable()->default(null);
            $table->string('identity_card_file')->nullable()->default(null);
            $table->string('npwp')->nullable()->default(null);

            $table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');

            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent');
    }
}
