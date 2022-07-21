<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArInvoiceV2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_invoice_v2', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customer');

            $table->string('number');
            $table->date('date');
            $table->date('due_date');

            $table->double('discount', 20, 2)->default(0);
            $table->double('tax_base', 20, 2);
            $table->double('tax', 20, 2);
            $table->double('grand_total', 20, 2);

            $table->string('payer_cid')->nullable();
            $table->string('payer_name')->nullable();
            $table->string('payer_address')->nullable();
            $table->string('payer_email')->nullable();
            $table->string('payer_postal_code')->nullable();
            $table->string('payer_phone_number')->nullable();
            $table->string('payer_fax')->nullable();

            $table->unsignedBigInteger('payer_province_id')->nullable();
            $table->foreign('payer_province_id')->references('id')->on('province')->onDelete('set null');
            $table->string('payer_province_name')->nullable();

            $table->unsignedBigInteger('payer_district_id')->nullable();
            $table->foreign('payer_district_id')->references('id')->on('district')->onDelete('set null');
            $table->string('payer_district_name')->nullable();

            $table->unsignedBigInteger('payer_sub_district_id')->nullable();
            $table->foreign('payer_sub_district_id')->references('id')->on('sub_district')->onDelete('set null');
            $table->string('payer_sub_district_name')->nullable();

            $table->unsignedBigInteger('payer_village_id')->nullable();
            $table->foreign('payer_village_id')->references('id')->on('village')->onDelete('set null');
            $table->string('payer_village_name')->nullable();

            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('brand_id')->references('id')->on('product_brand')->onDelete('set null');
            $table->string('brand_name')->nullable();

            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');

            $table->string('receiver_name')->nullable();
            $table->string('receiver_address')->nullable();
            $table->string('receiver_postal_code')->nullable();
            $table->string('receiver_phone_number')->nullable();
            $table->string('receiver_fax')->nullable();
            $table->string('receiver_email')->nullable();

            $table->string('proof_of_payment')->nullable();
            $table->timestamp('email_sent_at')->nullable();

            $table->unsignedBigInteger('billing_bank_id')->nullable();
            $table->foreign('billing_bank_id')->references('id')->on('bank')->onDelete('set null');

            $table->unsignedBigInteger('billing_receiver')->nullable();
            $table->foreign('billing_receiver')->references('id')->on('employee')->onDelete('set null');

            $table->string('billing_bank_name')->nullable();
            $table->string('billing_bank_account_number')->nullable();
            $table->string('billing_bank_account_on_behalf_of')->nullable();
            $table->string('billing_receiver_name')->nullable();

            $table->boolean('available_via_midtrans')->default(false);
            $table->boolean('paid_via_midtrans')->default(false);

            $table->boolean('received_by_agent')->default(false);
            $table->timestamp('received_by_agent_at')->nullable();

            $table->boolean('reminder_email_sent')->default(false);
            $table->timestamp('reminder_email_sent_at')->nullable();

            $table->boolean('whatsapp_sent')->default(false);
            $table->timestamp('whatsapp_sent_at')->nullable();

            $table->boolean('reminder_whatsapp_sent')->default(false);
            $table->timestamp('reminder_whatsapp_sent_at')->nullable();

            $table->boolean('receipt_email_sent')->default(false);
            $table->timestamp('receipt_email_sent_at')->nullable();

            $table->boolean('receipt_whatsapp_sent')->default(false);
            $table->timestamp('receipt_whatsapp_sent_at')->nullable();

            $table->boolean('created_by_cron')->default(false);
            $table->boolean('ignore_prorate')->default(false);
            $table->boolean('ignore_tax')->default(false);
            $table->boolean('postpaid')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ar_invoice_v2');
    }
}
