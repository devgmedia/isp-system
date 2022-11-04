<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\TrialTasking as TrialTaskingModel;
use Ramsey\Uuid\Uuid;

class TrialTaskingObserver
{
    public function creating(TrialTaskingModel $TrialTasking)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (TrialTaskingModel::where('uuid', $uuid)->exists());
        if (!$TrialTasking->uuid) $TrialTasking->uuid = $uuid;
    }
}
