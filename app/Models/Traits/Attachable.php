<?php

namespace App\Models\Traits;

use App\Helpers\StorageHelper;
use App\Models\Actionlog;
use enshrined\svgSanitize\Sanitizer;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
trait Attachable
{

    /**
     * Just a property for the private_uploads path
     *
     * @var string
     */
    protected string $privateUploads = 'private_uploads/';

    /**
     * Determine the name of the directory for the files based off the model class
     *
     * @return string
     */
    public function getDirectory(): string
    {
        return Str::of(self::class)->classBasename()->lower()->plural()->__toString();
    }

    /**
     * Generates file name with proper prefix, id, randomness, and original file name
     *
     * @param UploadedFile $file
     * @return string
     */
    private function generateFileName(UploadedFile $file): string
    {
        // Directory => file slug
        // IE asset uploads are stored in assets/, while the file is prefixed hardware
        $slugOverride = [
            'assets' => 'hardware',
            'assetmodels' => 'model'
        ];
        $slug = array_key_exists($this->getDirectory(), $slugOverride)
            ? $slugOverride[$this->getDirectory()]
            : $this->getDirectory();

        return
            $slug .
            '-' .
            $this->id .
            '-' .
            str_random(8) .
            '-' .
            str_slug(basename($file->getClientOriginalName(), '.' . $file->getClientOriginalExtension())) .
            '.' .
            $file->getClientOriginalExtension();
    }

    private function storeSanitizedSvg(UploadedFile $file, string $fileName)
    {
        $sanitizer = new Sanitizer();
        try {
            Storage::put(
                $this->privateUploads . $this->getDirectory() . '/' . $fileName,
                $sanitizer->sanitize($file->getContent())

            );
        } catch (\Exception $e) {
            Log::debug('Upload no workie :( ');
            Log::debug($e);
        }

    }

    /**
     * Store uploaded files and log the upload
     *
     * @param array $files
     * @param $notes
     * @return void
     */
    public function storeFiles(array $files, $notes): void
    {
        foreach ($files as $file) {
            $fileName = $this->generateFileName($file);
            // Check for SVG and sanitize it
            if ($file->getClientOriginalExtension() === 'svg' || str_contains($file->getMimeType(), 'svg')) {
//                dd("this is an svg");
                Log::debug('This is an SVG');
                $this->storeSanitizedSvg($file, $fileName);
            } else {
                $file->storeAs($this->privateUploads . $this->getDirectory(), $fileName);
            }

            $this->logUpload($fileName, e($notes));
        }
    }

    /**
     * @param Actionlog $log
     * @return void
     */
    public function destroyFile(ActionLog $log): void
    {
        if ($log->delete()) {
            Storage::delete($this->privateUploads . $this->getDirectory() . '/' . $log->filename);
        }
    }

    /**
     * @param string $fileName
     * @return mixed
     */
    public function showFile(string $fileName)
    {
        $file = $this->privateUploads . '/' . $this->getDirectory() . '/' . $fileName;
        Log::debug('Checking for ' . $file);
        if (Storage::missing($file)) {
            return response('File ' . $file . ' not found on server', 404)
                ->header('Content-Type', 'text/plain');
        }
        return StorageHelper::downloader($file);
    }
}