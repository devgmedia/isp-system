<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\TrialReporting as TrialReportingModel;
use Ramsey\Uuid\Uuid;

class TrialReportingObserve
{
    public function creating(TrialReportingModel $TrialReporting)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (TrialReportingModel::where('uuid', $uuid)->exists());
        if (!$TrialReporting->uuid) $TrialReporting->uuid = $uuid;
    }
}
