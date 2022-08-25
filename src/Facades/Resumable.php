<?php

namespace Gmedia\IspSystem\Facades;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Resumable
{
    public static function save(UploadedFile $file, $file_path, $disk = null)
    {
        if (! $disk) {
            $disk = config('filesystems.primary_disk');
        }

        $file_name = static::md5FileName($file);
        $storage = Storage::disk($disk);
        $file_url = $storage->url($storage->putFileAs($file_path, $file, $file_name, 'public'));

        return response([
            'file_name' => $file_name,
            'file_url' => $file_url,
            'file_path' => $file_path,
        ]);
    }

    public static function md5FileName(UploadedFile $file)
    {
        $file_extension = $file->getClientOriginalExtension();

        $file_name = str_replace('.'.$file_extension, '', $file->getClientOriginalName());
        $file_name .= '_'.md5(time()).'.'.$file_extension;

        return $file_name;
    }
}
