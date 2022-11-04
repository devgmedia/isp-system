<?php

namespace Gmedia\IspSystem\Facades;
   
use Gmedia\IspSystem\Models\Item;  
use Carbon\Carbon;
use Endroid\QrCode\QrCode as EndroidQrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use niklasravnsborg\LaravelPdf\PdfWrapper;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Output\ConsoleOutput;  

class ItemReplaceNumber
{ 
    public static function ReplaceNumber($item)
    { 
        $output = new ConsoleOutput();
        $output->writeln('<info>Number Old:</info> ' . $item->number);
 
        $numbernew = str_replace("-","/",$item->number); 
 
        $output->writeln('<info>Number New:</info> ' . $numbernew);

        Item::where('id', $item->id)
            ->update([
                'number' => $numbernew,
            ]); 
    } 

    public static function Replace()
    {
        $log = applog('erp__erp1_fac');
        $log->save('migrate ItemErp1 to item type');
         
        foreach (Item::cursor() as $item)
        {       
            static::ReplaceNumber($item);
        }        
    }
}
