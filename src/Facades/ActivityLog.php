<?php

namespace Gmedia\IspSystem\Facades;

use Gmedia\IspSystem\Models\ActivityLog as ModelsActivityLog;

class ActivityLog
{
    public static function clear()
    {
        ModelsActivityLog::whereRaw('created_at <= date_sub(curdate(), interval 3 month)')->delete();
    }
}
