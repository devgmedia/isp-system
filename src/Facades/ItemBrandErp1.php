<?php

namespace Gmedia\IspSystem\Facades;

use Gmedia\IspSystem\Models\ItemBrand;
use Gmedia\IspSystem\Models\ItemBrandProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\Console\Output\ConsoleOutput;

class ItemBrandErp1
{
    public static function migrateItemBrand(
        $item_brand,
        $conn
    )
    {
        // uuid
        $uuid = $item_brand->uuid;

        if (!$uuid) do {
            $uuid = Uuid::uuid4();
        } while (
            ItemBrand::where('uuid', $uuid)->exists()
            OR ItemBrandProduct::where('uuid', $uuid)->exists()
            OR DB::connection($conn)->table('gmd_item_categories')->where('uuid', $uuid)->exists()
        );

        DB::connection($conn)
            ->table('gmd_item_categories')
            ->where('id', $item_brand->id)
            ->update(['uuid' => $uuid]);

        static::migrateItemBrandUuid($uuid, $conn);
    }

    public static function migrateItemBrandUuid(
        $uuid,
        $conn
    )
    {

        $item_brand = DB::connection($conn)
            ->table('gmd_item_categories')
            ->where('uuid', $uuid)
            ->first();

        if ($item_brand->up == 0) {
            $output = new ConsoleOutput();
            $output->writeln('<info>Uuid:</info> ' . $uuid);

            $output->writeln('<comment>Perparing migrate . . .</comment>');
            if (!ItemBrand::where('uuid', $uuid)->exists()) {
                ItemBrand::create([
                    'uuid' => $item_brand->uuid,
                    'name' => $item_brand->item_categories,
                ]);
                $output->writeln('<info>Item Brand id:</info> ' . $item_brand->id);
             }else{
                ItemBrand::where('uuid', $item_brand->uuid)->update([
                    'name' => $item_brand->item_categories,
                ]);

                $output->writeln('<info>Item Brand Update id:</info> ' . $item_brand->id);
             }
        }
    }

    public static function migrateItemBrandData()
    {
        $log = applog('erp__erp1_fac');
        $log->save('migrate ItemErp1item brand');

        foreach (DB::connection('erp1')->table('gmd_item_categories')->cursor() as $item_brand)
        {
            static::migrateItemBrand($item_brand, 'erp1');
        }
    }

    public static function migrateItemBrandProduct(
        $item_brand,
        $conn
    )
    {
        // uuid
        $uuid = $item_brand->uuid;

        if (!$uuid) do {
            $uuid = Uuid::uuid4();
        } while (
            ItemBrand::where('uuid', $uuid)->exists()
            OR ItemBrandProduct::where('uuid', $uuid)->exists()
            OR DB::connection($conn)->table('gmd_item_categories')->where('uuid', $uuid)->exists()
        );

        DB::connection($conn)
            ->table('gmd_item_categories')
            ->where('id', $item_brand->id)
            ->update(['uuid' => $uuid]);

        static::migrateItemBrandProductUuid($uuid, $conn);
    }

    public static function migrateItemBrandProductUuid(
        $uuid,
        $conn
    )
    {

        $item_brand = DB::connection($conn)
            ->table('gmd_item_categories')
            ->where('uuid', $uuid)
            ->first();

        if ($item_brand->up != 0) {

            $output = new ConsoleOutput();
            $output->writeln('<info>Uuid:</info> ' . $uuid);
            $output->writeln('<comment>Perparing migrate . . .</comment>');

            $item_brand_erp1 = DB::connection('erp1')->table('gmd_item_categories')->where('id', $item_brand->up)->first();

            $item_brand_new_erp = ItemBrand::where('uuid', $item_brand_erp1->uuid)->first();

            if (!ItemBrandProduct::where('uuid', $uuid)->exists()) {
                ItemBrandProduct::create([
                    'uuid' => $item_brand->uuid,
                    'name' => $item_brand->item_categories,
                    'brand_id' => $item_brand_new_erp->id,
                ]);
                $output->writeln('<info>Item Brand Product id:</info> ' . $item_brand->id);
            }else{
                ItemBrandProduct::where('uuid', $item_brand->uuid)->update([
                    'name' => $item_brand->item_categories,
                    'brand_id' => $item_brand_new_erp->id,
                ]);
                $output->writeln('<info>Item Brand Product Update id:</info> ' . $item_brand->id);
            }
        }
    }


    public static function migrateItemBrandProductData()
    {
        $log = applog('erp__erp1_fac');
        $log->save('migrate ItemErp1item brand');

        foreach (DB::connection('erp1')->table('gmd_item_categories')->cursor() as $item_brand)
        {
            static::migrateItemBrandProduct($item_brand, 'erp1');
        }
    }
}
