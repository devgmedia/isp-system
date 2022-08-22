<?php

namespace Gmedia\IspSystem\Facades;

class ZipStream
{
    public static function set($disk_name = 's3')
    {
        $disk = config('filesystems.disks.'.$disk_name);

        $config = config('zipstream');

        $config['aws']['credentials'] = [
            'key' => $disk['key'],
            'secret' => $disk['secret'],
        ];
        $config['aws']['endpoint'] = $disk['endpoint'];
        $config['aws']['use_path_style_endpoint'] = array_key_exists('use_path_style_endpoint', $disk) ?
            $disk['use_path_style_endpoint'] :
            false;
        $config['aws']['region'] = $disk['region'];

        config(['zipstream' => $config]);

        return $disk['bucket'];
    }
}
