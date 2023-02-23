<?php

namespace Gmedia\IspSystem\Observers;

use App\Models\User;
use Faker\Factory as Faker;
use Gmedia\IspSystem\Facades\Customer;
use Gmedia\IspSystem\Models\PreCustomer as PreCustomerModel;
use Gmedia\IspSystem\Models\ProductBrand;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Models\Role;

class PreCustomerObserver
{
    public function creating(PreCustomerModel $preCustomer)
    {
        // cid
        if (! $preCustomer->cid) {
            $preCustomer->cid = Customer::generateCid($preCustomer->branch);
        }
        $uuid = $preCustomer->uuid;

        // uuid
        if (! $preCustomer->uuid) {
            do {
                $uuid = Uuid::uuid4();
            } while (PreCustomerModel::where('uuid', $uuid)->exists());
            $preCustomer->uuid = $uuid;
        }
        // uuid
        if (! $preCustomer->code_verification) {
            do {
                $code_verification = strtoupper(uniqid());
            } while (PreCustomerModel::where('code_verification', $code_verification)->exists());

            $preCustomer->code_verification = $code_verification;
        }
        // user_id
        if (! $preCustomer->user_id) {
            $password = Faker::create()->regexify('[A-Za-z0-9]{8}');
            $brand = ProductBrand::find($preCustomer->brand_id);
            if ($brand) {
                $password = Hash::make($brand->pre_customer_account_default_password);
            }

            $user = User::create([
                'name' => 'pre_customer_'.$uuid,
                'email' => $preCustomer->email,
                // 'password' => Hash::make($password),
                'password' => $password,
                'api_token' => Str::random(80),
            ]);
            $role = Role::where('name', 'pre_customer')->get();
            $user->assignRole($role);

            $preCustomer->user_id = $user->id;
            // send password to pre_customer email
        }
    }

    /**
     * Handle the Precustomer "created" event.
     *
     * @return void
     */
    public function created(PreCustomerModel $preCustomer)
    {
        //
    }

    /**
     * Handle the Precustomer "updated" event.
     *
     * @return void
     */
    public function updated(PreCustomerModel $preCustomer)
    {
        //
    }

    /**
     * Handle the Precustomer "deleted" event.
     *
     * @return void
     */
    public function deleted(PreCustomerModel $preCustomer)
    {
        //
    }

    /**
     * Handle the Precustomer "restored" event.
     *
     * @return void
     */
    public function restored(PreCustomerModel $preCustomer)
    {
        //
    }

    /**
     * Handle the Precustomer "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(PreCustomerModel $preCustomer)
    {
        //
    }
}
