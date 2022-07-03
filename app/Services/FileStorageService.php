<?php

namespace App\Services;

use App\Helpers\StorageHelper;
use App\Models\Actionlog;
use enshrined\svgSanitize\Sanitizer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileStorageService
{

    private static string $uploadsDir = 'private_uploads/';

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

    public static function store(string $directory, array $files, Model $model, $notes, string $fileSlug = ''): void {
        if (Storage::missing(FileStorageService::$uploadsDir . $directory)) {
            Storage::makeDirectory(FileStorageService::$uploadsDir . $directory);
        }
        $fileSlug = $fileSlug ?? str_singular($directory);

        foreach ($files as $file) {
            $fileName = FileStorageService::generateFileName($fileSlug, $model->id, $file);

            // Check for SVG and sanitize it
            if ($file->getClientOriginalExtension() === 'svg') {
                \Log::debug('This is an SVG');
                $sanitizer = new Sanitizer();
                try {
                    Storage::put(
                        FileStorageService::$uploadsDir . $directory . '/' . $fileName,
                        $sanitizer->sanitize($file->getContent())
                    );
                } catch (\Exception $e) {
                    \Log::debug('Upload no workie :( ');
                    \Log::debug($e);
                }
            } else {
                Storage::put(FileStorageService::$uploadsDir . $directory . '/' . $fileName, $file->getContent());
            }
            $model->logUpload($fileName, e($notes));
        }
    }

    public static function destroy(string $directory, ActionLog $log)
    {
        $log->delete();
        Storage::delete(FileStorageService::$uploadsDir . $directory . '/' . $log->filename);
    }

    public static function show(string $directory, string $fileName)
    {
        $file = FileStorageService::$uploadsDir . '/' . $directory . '/' . $fileName;
        \Log::debug('Checking for ' . $file);
        if (Storage::missing($file)) {
            return response('File ' . $file . ' not found on server', 404)
                ->header('Content-Type', 'text/plain');
        }
        return StorageHelper::downloader($file);
    }
}