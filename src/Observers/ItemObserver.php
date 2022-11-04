<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Item;
use Gmedia\IspSystem\Models\Branch as BranchModel;
use Ramsey\Uuid\Uuid;

use niklasravnsborg\LaravelPdf\Facades\Pdf as PDF;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use niklasravnsborg\LaravelPdf\PdfWrapper;
use Endroid\QrCode\QrCode as EndroidQrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Color\Color;
use Carbon\Carbon;

class ItemObserver
{
    /**
     * Handle the item "created" event.
     *
     * @param  \Gmedia\IspSystem\Item  $item
     * @return void
     */
    public function creating(Item $item)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Item::where('uuid', $uuid)->exists());
        if (!$item->uuid) $item->uuid = $uuid;

        $date = Carbon::now();
        $branch_id = $item->branch_id;
        $brand_id = $item->brand_id;
        $brand_product_id = $item->brand_product_id;
        $first_date = date('Y-m-', strtotime($date)).'01';
        $last_date = date('Y-m-t', strtotime($first_date));

        $latest = Item::where('branch_id', $branch_id)
            ->where('created_at', '>=', $first_date)
            ->where('created_at', '<=', $last_date)
            ->latest('id') 
            ->first();
            
        $latest_number = !empty($latest) ? $latest->number : 0;

        $urut_arr = explode('/', $latest_number);
        $urut = $urut_arr[count($urut_arr)-1];
        $no = sprintf('%04d', $urut+=1); 
   
        // get branch code
        $branch_code = BranchModel::find($branch_id)->code;

        $number = 'ITEM/'.$branch_code.'/'.date('ym', strtotime($date)).'/'.$no;
        // end generate no item

        $item->number = $number;

        $data['qr_code'] = (new PngWriter())
            ->write(
                EndroidQrCode::create($number)
                    ->setSize(135)
                    ->setMargin(0),
                Logo::create('libraries/frest-admin/app-assets/images/logo/logo-black-v2.png')
                    ->setResizeToWidth(20)
            )
            ->getDataUri();   

        $data['number'] = $number;
        $data['item_name'] = $item->name;
        $data['item_created_at'] = $item->created_at;
        $data['warranty_end_date'] = $item->warranty_end_date;
        $data['expiration_date'] = $item->expiration_date;
 
        $pdf = (new PdfWrapper())->loadView('pdf.item.barcode_doc', $data, [], [
            'format' => [50, 50],
            // 'orientation' => 'landscape',
            'title' => 'Invoice',
            'creator' => 'GMedia', 
        ]);

        $file_path = 'item/'.str_replace('/', '_', $number).'.pdf';
        $storage = Storage::disk(config('disk.primary'));
        if ($storage->exists($file_path)) $storage->delete($file_path);
        $storage->put($file_path, $pdf->output(), 'public');
    }

    public function created(Item $item)
    {
        //
    }

    /**
     * Handle the item "updated" event.
     *
     * @param  \Gmedia\IspSystem\Item  $item
     * @return void
     */
    public function updated(Item $item)
    {
        //
    }

    /**
     * Handle the item "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Item  $item
     * @return void
     */
    public function deleted(Item $item)
    {
        //
    }

    /**
     * Handle the item "restored" event.
     *
     * @param  \Gmedia\IspSystem\Item  $item
     * @return void
     */
    public function restored(Item $item)
    {
        //
    }

    /**
     * Handle the item "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Item  $item
     * @return void
     */
    public function forceDeleted(Item $item)
    {
        //
    }
}
