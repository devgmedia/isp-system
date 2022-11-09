<?php

namespace Gmedia\IspSystem\Jobs;

use Gmedia\IspSystem\Facades\ArInvoice;
use Gmedia\IspSystem\Models\ArInvoice as ArInvoiceModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ArInvoiceQiscusGetWhatsappReceipt implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoice_id;

    protected $broadcast_job_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($invoice_id, $broadcast_job_id)
    {
        $this->invoice_id = $invoice_id;
        $this->broadcast_job_id = $broadcast_job_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $invoice = ArInvoiceModel::find($this->invoice_id);
        if ($invoice) {
            ArInvoice::qiscusGetWhatsappReceipt($invoice, $this->broadcast_job_id);
        }
    }
}
