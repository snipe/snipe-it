<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StorageHelper
{
    const uploadsDirectory = 'private_uploads/';

    public static function generateFileName($slug, $id, UploadedFile $file): string
    {
        return
            $slug .
            '-' .
            $id .
            '-' .
            str_random(8) .
            '-' .
            str_slug(basename($file->getClientOriginalName(), '.' . $file->getClientOriginalExtension())) .
            '.' .
            $file->getClientOriginalExtension();
    }

    public static function downloader($filename, $disk = 'default')
    {
        if ($disk == 'default') {
            $disk = config('filesystems.default');
        }
        switch (config("filesystems.disks.$disk.driver")) {
            case 'local':
                return response()->download(Storage::disk($disk)->path($filename)); //works for PRIVATE or public?!

            case 's3':
                return redirect()->away(Storage::disk($disk)->temporaryUrl($filename, now()->addMinutes(5))); //works for private or public, I guess?

            default:
                return Storage::disk($disk)->download($filename);
        }
    }
}