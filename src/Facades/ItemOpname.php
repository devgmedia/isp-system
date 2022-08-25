<?php

namespace Gmedia\IspSystem\Facades;

use Gmedia\IspSystem\Models\Branch as BranchModel;
use Gmedia\IspSystem\Models\Item as ItemModel;
use Gmedia\IspSystem\Models\ItemOpname as ItemOpnameModel;
use Gmedia\IspSystem\Models\ItemType as ItemTypeModel;
use Symfony\Component\Console\Output\ConsoleOutput;

class ItemOpname
{
    public static function create()
    {
        $log = applog('erp, item_opname, create');

        $output = new ConsoleOutput();

        foreach (ItemTypeModel::cursor() as $itemtype) {
            foreach (BranchModel::cursor() as $branch) {
                $available = ItemModel::where('item_type_id', $itemtype->id)
                    ->where('from_ownership_branch_id', $branch->id)
                    ->count();

                $total = ItemModel::where('item_type_id', $itemtype->id)
                    ->count();

                if ($itemtype->id == 116) {
                    $output->writeln('<info>Item :</info> '.$itemtype->name);
                    $output->writeln('<info>Available :</info> '.$available);
                    $output->writeln('<info>Total :</info> '.$total);
                    $output->writeln('<info>Branch :</info> '.$branch->name);
                }
            }
        }

        // foreach($item as $value){
        //     $output->writeln('<info>Item Number :</info> ' . $item->number);
        // }

        // $data = [
        //     'available' => 1,
        //     'total' => 1,
        //     'item_id' => 1,
        // ];

        // ItemOpnameModel::create($data);
    }
}
