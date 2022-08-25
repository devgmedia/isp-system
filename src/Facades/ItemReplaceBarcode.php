<?php

namespace Gmedia\IspSystem\Facades;

use Gmedia\IspSystem\Models\Item;
use Carbon\Carbon;
use Endroid\QrCode\QrCode as EndroidQrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Color\Color;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use niklasravnsborg\LaravelPdf\PdfWrapper;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Output\ConsoleOutput;

class ItemReplaceBarcode
{
    public static function ReplaceBarcode($item)
    {
        $output = new ConsoleOutput();
        $output->writeln('<info>Number:</info> ' . $item->number);

        $data['qr_code'] = (new PngWriter())->write(
            EndroidQrCode::create($item->number)
                ->setSize(135)
                ->setMargin(0),
            Logo::create(url('libraries/frest-admin/app-assets/images/logo/logo-black-v2.png'))
                ->setResizeToWidth(20)
            )
            ->getDataUri();

        $data['number'] = $item->number;
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

        $file_path = 'item/'.str_replace('/', '_', $item->number).'.pdf';
        $storage = Storage::disk(config('filesystems.primary_disk'));
        if ($storage->exists($file_path)) $storage->delete($file_path);
        $storage->put($file_path, $pdf->output(), 'public');
    }

    public static function Replace()
    {
        $log = applog('erp__erp1_fac');
        $log->save('migrate ItemErp1 to item type');

        foreach (Item::cursor() as $item)
        {
            static::ReplaceBarcode($item);
        }
    }
}
