<?php

namespace Gmedia\IspSystem\Jobs;

use Gmedia\IspSystem\Facades\ArInvoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Gmedia\IspSystem\Models\ArInvoice as ModelsArInvoice;

class ArInvoiceCreatePdfRetailInternet implements ShouldQueue
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
        $invoice = ModelsArInvoice::find($this->invoice_id);
        if ($invoice) ArInvoice::createPdfRetailInternet($invoice, $this->disk);
    }
}
