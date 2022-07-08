<?php

namespace Gmedia\IspSystem\Facades;

use Gmedia\IspSystem\Models\ActivityLog as ActivityLogModel;

class ActivityLog
{
    public static function clear()
    {
        ActivityLogModel::whereRaw('created_at <= date_sub(curdate(), interval 3 month)')->delete();
    }
}
