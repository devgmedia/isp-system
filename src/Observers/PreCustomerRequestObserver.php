<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Employee;
use Gmedia\IspSystem\Models\PreCustomerRequest;
use Gmedia\IspSystem\Models\ProductBrand;
use app\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Models\Role;
use Faker\Factory as Faker;

class PreCustomerRequestObserver
{
    public function creating(PreCustomerRequest $preCustomerRequest)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (PreCustomerRequest::where('uuid', $uuid)->exists());
        $preCustomerRequest->uuid = $uuid;
        
        $password = Faker::create()->regexify('[A-Za-z0-9]{8}');
        $brand = ProductBrand::find($preCustomerRequest->brand_id);
        if ($brand) $password = Hash::make($brand->agent_account_default_password);

        $user = User::create([
            'name' => 'pre_customer_'.$uuid,
            // 'email' => $preCustomerRequest->email,
            // 'password' => Hash::make($password),
            'password' => $password,
            'api_token' => Str::random(80),
        ]);
        $role = Role::where('name', 'pre_customer')->get();
        $user->assignRole($role);
        
        $preCustomerRequest->user_id = $user->id;
        $preCustomerRequest->submit_by = Employee::where('user_id', Auth::guard('api')->id())->value('id');
        $preCustomerRequest->submit_at = Carbon::now()->toDateTimeString();
    }

    /**
     * Handle the supplier "created" event.
     *
     * @param  \Gmedia\IspSystem\models\PreCustomerRequest  $preCustomerRequest
     * @return void
     */
    public function created(PreCustomerRequest $preCustomerRequest)
    {
        //
    }

    /**
     * Handle the supplier "updated" event.
     *
     * @param  \Gmedia\IspSystem\models\PreCustomerRequest  $preCustomerRequest
     * @return void
     */
    public function updated(PreCustomerRequest $preCustomerRequest)
    {
        //
    }

    /**
     * Handle the supplier "deleted" event.
     *
     * @param  \Gmedia\IspSystem\models\PreCustomerRequest  $preCustomerRequest
     * @return void
     */
    public function deleted(PreCustomerRequest $preCustomerRequest)
    {
        //
    }

    /**
     * Handle the supplier "restored" event.
     *
     * @param  \Gmedia\IspSystem\models\PreCustomerRequest  $preCustomerRequest
     * @return void
     */
    public function restored(PreCustomerRequest $preCustomerRequest)
    {
        //
    }

    /**
     * Handle the supplier "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\models\PreCustomerRequest  $preCustomerRequest
     * @return void
     */
    public function forceDeleted(PreCustomerRequest $preCustomerRequest)
    {
        //
    }
}
