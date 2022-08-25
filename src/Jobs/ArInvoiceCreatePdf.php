<?php

namespace Gmedia\IspSystem\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Gmedia\IspSystem\Facades\ArInvoice;
use Gmedia\IspSystem\Models\ArInvoice as ArInvoiceModel;

class ArInvoiceCreatePdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoice_id;
    protected $disk;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($invoice_id, $disk = null)
    {
        $this->invoice_id = $invoice_id;
        $this->disk = $disk;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $invoice = ArInvoiceModel::find($this->invoice_id);
        if ($invoice) ArInvoice::createPdf($invoice, $this->disk);
    }
}
