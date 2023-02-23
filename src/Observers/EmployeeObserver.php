<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Employee;
use Ramsey\Uuid\Uuid;

class EmployeeObserver
{
    public function creating(Employee $employee)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Employee::where('uuid', $uuid)->exists());
        if (! $employee->uuid) {
            $employee->uuid = $uuid;
        }
    }

    /**
     * Handle the employee "created" event.
     *
     * @return void
     */
    public function created(Employee $employee)
    {
        //
    }

    /**
     * Handle the employee "updated" event.
     *
     * @return void
     */
    public function updated(Employee $employee)
    {
        //
    }

    /**
     * Handle the employee "deleted" event.
     *
     * @return void
     */
    public function deleted(Employee $employee)
    {
        //
    }

    /**
     * Handle the employee "restored" event.
     *
     * @return void
     */
    public function restored(Employee $employee)
    {
        //
    }

    /**
     * Handle the employee "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Employee $employee)
    {
        //
    }
}
