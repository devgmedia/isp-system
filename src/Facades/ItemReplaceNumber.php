<?php

namespace Gmedia\IspSystem\Facades;

use Gmedia\IspSystem\Models\Item;
use Symfony\Component\Console\Output\ConsoleOutput;

class ItemReplaceNumber
{
    public static function ReplaceNumber($item)
    {
        $output = new ConsoleOutput();
        $output->writeln('<info>Number Old:</info> '.$item->number);

        $numbernew = str_replace('-', '/', $item->number);

        $output->writeln('<info>Number New:</info> '.$numbernew);

        Item::where('id', $item->id)
            ->update([
                'number' => $numbernew,
            ]);
    }

    public static function Replace()
    {
        $log = applog('erp__erp1_fac');
        $log->save('migrate ItemErp1 to item type');

        foreach (Item::cursor() as $item) {
            static::ReplaceNumber($item);
        }
    }
}
