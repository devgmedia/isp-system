<?php

namespace Gmedia\IspSystem\Facades;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StorageSchema
{
    public static function get_file_storage($path_file)
    {
        $checkFile = Storage::disk(config('filesystems.primary_disk'))->exists($path_file);

        if (!$checkFile) {
            abort(404);
        }

        $file = Storage::disk(config('filesystems.primary_disk'))->get($path_file);
        $mimeType = Storage::disk(config('filesystems.primary_disk'))->getMimeType($path_file);

        $response = [
            'Content-Type' => $mimeType,
        ];

        $data = [
            "file" => $file,
            "response" => $response,
        ];

        return $data;
    }
}
