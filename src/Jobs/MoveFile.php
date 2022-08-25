<?php

namespace Gmedia\IspSystem\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class MoveFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $from_disk;
    protected $from_path;

    protected $to_disk;
    protected $to_path;

    protected $availability;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($from_disk, $from_path, $to_disk, $to_path, $availability = 'public')
    {
        $this->from_disk = $from_disk;
        $this->from_path = $from_path;

        $this->to_disk = $to_disk;
        $this->to_path = $to_path;

        $this->availability = $availability;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $log = applog('erp__move_file_job');
        $log->save('handle');

        $from_storage = Storage::disk($this->from_disk);
        $file = $from_storage->get($this->from_path);

        $to_storage = Storage::disk($this->to_disk);
        $to_storage->put($this->to_path, $file, $this->availability);
    }
}
