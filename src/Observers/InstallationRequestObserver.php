<?php

namespace Gmedia\IspSystem\Observers;

use Carbon\Carbon;
use Gmedia\IspSystem\Models\Employee;
use Gmedia\IspSystem\Models\InstallationRequest as InstallationRequestModel;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class InstallationRequestObserver
{
    public function creating(InstallationRequestModel $InstallationRequest)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (InstallationRequestModel::where('uuid', $uuid)->exists());
        if (! $InstallationRequest->uuid) {
            $InstallationRequest->uuid = $uuid;
        }

        $employe = Employee::where('user_id', Auth::id())->first();
        $installation = InstallationRequestModel::where('branch_id', $employe->branch->id)
            ->whereYear('created_at', '=', date('Y'))
            ->whereMonth('created_at', '=', date('m'))
            ->count();

        $code_date = Carbon::now()->format('my');

        $number = $installation + 1;
        $num_padded = sprintf('%04s', $number);

        $InstallationRequest->number = 'IRE/'.$employe->branch->code.'/'.$code_date.'/'.$num_padded;
    }
}
