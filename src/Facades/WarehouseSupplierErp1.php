<?php

namespace Gmedia\IspSystem\Facades;

use Gmedia\IspSystem\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\Console\Output\ConsoleOutput;

class WarehouseSupplierErp1
{
    public static function migrateSupplier(
        $supplier,
        $conn
    )
    {
        // uuid
        $uuid = $supplier->uuid;

        if (!$uuid) do {
            $uuid = Uuid::uuid4();
        } while (
            Supplier::where('uuid', $uuid)->exists()
            OR DB::connection($conn)->table('gmd_supplier')->where('uuid', $uuid)->exists()
        );

        DB::connection($conn)
            ->table('gmd_supplier')
            ->where('id', $supplier->id)
            ->update(['uuid' => $uuid]);

        static::migrateSupplierUuid($uuid, $conn);
    }

    public static function migrateSupplierUuid(
        $uuid,
        $conn
    )
    {
        $output = new ConsoleOutput();
        $output->writeln('<info>Uuid:</info> ' . $uuid);

        $output->writeln('<comment>Perparing migrate . . .</comment>');

        $supplier = DB::connection($conn)
            ->table('gmd_supplier')
            ->where('uuid', $uuid)
            ->first();

        if (!Supplier::where('uuid', $uuid)->exists()) {
            $output->writeln('<info>Supplier id:</info> ' . $supplier->id);

            Supplier::create([
                'uuid' => $supplier->uuid,
                'name' => $supplier->supplier_name,
                'address' => $supplier->supplier_address,
                'brand_id' => $brand->id,
                'brand_product_id' => $brand_product->id,
            ]);
        }else{
            $output->writeln('<info>Supplier Update id:</info> ' . $supplier->id);

            Supplier::where('uuid', $supplier->uuid)->update([
                'name' => $supplier->supplier_name,
                'brand_id' => $brand->id,
                'brand_product_id' => $brand_product->id,
            ]);
        }
    }

    public static function migrateSupplierData()
    {
        $log = applog('erp__erp1_fac');
        $log->save('migrate WarehouseSupplierErp1 to warehouse supplier');

        foreach (DB::connection('erp1')->table('gmd_supplier')->cursor() as $supplier)
        {
            static::migrateSupplier($supplier, 'erp1');
        }
    }
}
