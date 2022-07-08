<?php

namespace Gmedia\IspSystem\Facades;
  
use Gmedia\IspSystem\Models\ItemType; 
use Gmedia\IspSystem\Models\ItemBrand;
use Gmedia\IspSystem\Models\ItemBrandProduct;  
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\Console\Output\ConsoleOutput;

class ItemTypeErp1
{ 
    public static function migrateItemType(
        $item,
        $conn
    )
    {
        // uuid
        $uuid = $item->uuid;

        if (!$uuid) do {
            $uuid = Uuid::uuid4();
        } while (
            ItemType::where('uuid', $uuid)->exists() 
            OR DB::connection($conn)->table('gmd_item')->where('uuid', $uuid)->exists()
        );

        DB::connection($conn)
            ->table('gmd_item')
            ->where('id', $item->id)
            ->update(['uuid' => $uuid]);

        static::migrateItemTypeUuid($uuid, $conn); 
    }

    public static function migrateItemTypeUuid(
        $uuid,
        $conn
    )
    { 
        $output = new ConsoleOutput();
        $output->writeln('<info>Uuid:</info> ' . $uuid);

        $output->writeln('<comment>Perparing migrate . . .</comment>');

        $item = DB::connection($conn)
            ->table('gmd_item')
            ->where('uuid', $uuid)
            ->first();
            
        $brand_erp1 = DB::connection($conn)
            ->table('gmd_item_categories')
            ->where('id', $item->brand)
            ->first();

        
        $brand_product_erp1 = DB::connection($conn)
            ->table('gmd_item_categories')
            ->where('id', $item->category_id)
            ->first();
        if ($brand_erp1 && $brand_product_erp1) {
            $brand = ItemBrand::where('uuid', $brand_erp1->uuid)->first();
            $brand_product = ItemBrandProduct::where('uuid', $brand_product_erp1->uuid)->first();

            $output->writeln('<info>Uuid Brand:</info> ' . $brand->uuid); 
            $output->writeln('<info>Uuid Brand Product:</info> ' . $brand_product->uuid);
    
            if (!ItemType::where('uuid', $uuid)->exists()) {
                $output->writeln('<info>Item Type id:</info> ' . $item->id);

                ItemType::create([
                    'uuid' => $item->uuid,
                    'name' => $item->item_name,
                    'brand_id' => $brand->id,
                    'brand_product_id' => $brand_product->id,
                ]);
            }else{
                $output->writeln('<info>Item Type Update id:</info> ' . $item->id);

                ItemType::where('uuid', $item->uuid)->update([ 
                    'name' => $item->item_name,
                    'brand_id' => $brand->id,
                    'brand_product_id' => $brand_product->id,
                ]); 
            }  
        }
    }

    public static function migrateItemTypeData()
    {
        $log = applog('erp__erp1_fac');
        $log->save('migrate ItemErp1 to item type');
         
        foreach (DB::connection('erp1')->table('gmd_item')->cursor() as $item)
        {       
            static::migrateItemType($item, 'erp1');
        }        
    }
}
