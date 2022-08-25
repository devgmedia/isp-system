<?php

namespace Gmedia\IspSystem\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Gmedia\IspSystem\Facades\ArInvoice;
use Gmedia\IspSystem\Facades\Log;

class MidtransGetStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order_id;
    protected $invoice_id;
    protected $log;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order_id, $invoice_id, Log $log)
    {
        $this->order_id = $order_id;
        $this->invoice_id = $invoice_id;
        $this->log = $log;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->log->new()->properties(['invoice_id' => $this->invoice_id])->save('queue update status');
        ArInvoice::midtransGetStatus($this->order_id);
    }
}
