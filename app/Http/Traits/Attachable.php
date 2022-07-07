<?php

namespace App\Http\Traits;

use App\Helpers\StorageHelper;
use App\Models\Actionlog;
use enshrined\svgSanitize\Sanitizer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait Attachable
{
    public function storeFile(string $directory, array $files, Model $model, $notes, string $fileSlug = ''): void {
        $fileSlug = $fileSlug ?? str_singular($directory);

        foreach ($files as $file) {
            $fileName = StorageHelper::generateFileName($fileSlug, $model->id, $file);

            // Check for SVG and sanitize it
            if ($file->getClientOriginalExtension() === 'svg') {
                Log::debug('This is an SVG');
                $sanitizer = new Sanitizer();
                try {
                    Storage::put(
                        StorageHelper::uploadsDirectory . $directory . '/' . $fileName,
                        $sanitizer->sanitize($file->getContent())
                    );
                } catch (Exception $e) {
                    Log::debug('Upload no workie :( ');
                    Log::debug($e);
                }
            } else {
                Storage::put(StorageHelper::uploadsDirectory . $directory . '/' . $fileName, $file->getContent());
            }
            $model->logUpload($fileName, e($notes));
        }
    }

    public function destroyFile(string $directory, ActionLog $log): void
    {
        if ($log->delete()) {
            Storage::delete(StorageHelper::uploadsDirectory . $directory . '/' . $log->filename);
        }
    }

    public function showFile(string $directory, string $fileName)
    {
        $file = StorageHelper::uploadsDirectory . '/' . $directory . '/' . $fileName;
        Log::debug('Checking for ' . $file);
        if (Storage::missing($file)) {
            return response('File ' . $file . ' not found on server', 404)
                ->header('Content-Type', 'text/plain');
        }
        return StorageHelper::downloader($file);
    }
}