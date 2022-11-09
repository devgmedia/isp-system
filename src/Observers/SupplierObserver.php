<?php

namespace Gmedia\IspSystem\Observers;

use app\Models\User;
use Gmedia\IspSystem\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class SupplierObserver
{
    public function creating(Supplier $supplier)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Supplier::where('uuid', $uuid)->exists());
        if (! $supplier->uuid) {
            $supplier->uuid = $uuid;
        }

        $user_id = Auth::guard('api')->id();
        if ($user_id) {
            $user = User::with('employee')->find($user_id);
            if ($user->employee) {
                $supplier->created_by = $user->employee->id;
            }
        }
    }

    /**
     * Handle the supplier "created" event.
     *
     * @param  \Gmedia\IspSystem\models\Supplier  $supplier
     * @return void
     */
    public function created(Supplier $supplier)
    {
        //
    }

    /**
     * Handle the supplier "updated" event.
     *
     * @param  \Gmedia\IspSystem\models\Supplier  $supplier
     * @return void
     */
    public function updated(Supplier $supplier)
    {
        //
    }

    /**
     * Handle the supplier "deleted" event.
     *
     * @param  \Gmedia\IspSystem\models\Supplier  $supplier
     * @return void
     */
    public function deleted(Supplier $supplier)
    {
        //
    }

    /**
     * Handle the supplier "restored" event.
     *
     * @param  \Gmedia\IspSystem\models\Supplier  $supplier
     * @return void
     */
    public function restored(Supplier $supplier)
    {
        //
    }

    /**
     * Handle the supplier "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\models\Supplier  $supplier
     * @return void
     */
    public function forceDeleted(Supplier $supplier)
    {
        //
    }
}
