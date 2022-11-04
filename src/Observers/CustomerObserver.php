<?php

namespace Gmedia\IspSystem\Observers;

use app\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Gmedia\IspSystem\Facades\Customer;
use Gmedia\IspSystem\Models\Customer as CustomerModel;
use Gmedia\IspSystem\Models\ProductBrand;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Models\Role;

class CustomerObserver
{
    public function creating(CustomerModel $customer)
    {
        // cid
        if (! $customer->cid) {
            $customer->cid = Customer::generateCid($customer->branch);
        }

        // registration_date
        $customer->registration_date = Carbon::now()->toDateString();

        // user_id
        if (! $customer->user_id) {
            $email = $customer->emails()->first();

            $password = Faker::create()->regexify('[A-Za-z0-9]{8}');
            $brand = ProductBrand::find($customer->brand_id);
            if ($brand) {
                $password = Hash::make($brand->customer_account_default_password);
            }

            $user = User::create([
                'name' => $customer->cid,
                'email' => $email ? $email->name : null,
                'password' => $password,
                'api_token' => Str::random(80),
            ]);

            $role = Role::where('name', 'client')->get();
            $user->assignRole($role);

            $customer->user_id = $user->id;
            // send password to customer email
        }

        // uuid
        if (! $customer->uuid) {
            $uuid = null;

            do {
                $uuid = Uuid::uuid4();
            } while (CustomerModel::where('uuid', $uuid)->exists());

            $customer->uuid = $uuid;
        }
    }

    /**
     * Handle the customer "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\Customer  $customer
     * @return void
     */
    public function created(CustomerModel $customer)
    {
        //
    }

    /**
     * Handle the customer "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\Customer  $customer
     * @return void
     */
    public function updated(CustomerModel $customer)
    {
        //
    }

    /**
     * Handle the customer "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\Customer  $customer
     * @return void
     */
    public function deleted(CustomerModel $customer)
    {
        //
    }

    /**
     * Handle the customer "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\Customer  $customer
     * @return void
     */
    public function restored(CustomerModel $customer)
    {
        //
    }

    /**
     * Handle the customer "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\Customer  $customer
     * @return void
     */
    public function forceDeleted(CustomerModel $customer)
    {
        //
    }
}
