<?php

namespace App\Http\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait ConvertsBase64ToFiles
{
    protected function base64FileKeys(): array
    {
        return [];
    }

    /**
     * Pulls the Base64 contents for each file key and creates
     * an UploadedFile instance from it and sets it on the
     * request.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $flattened = Arr::dot($this->base64FileKeys());

        Collection::make($flattened)->each(function ($filename, $key) {
            rescue(function () use ($key, $filename) {
                // dont process plain files
                if ( $this->file($key)){
                    return;
                }

                $base64Contents = $this->input($key);

                if (!$base64Contents) {
                    return;
                }
                
                // autogenerate filenames
                if ($filename == 'auto'){
                    $header = explode(';', $base64Contents, 2)[0];
                    // Grab the image type from the header while we're at it.
                    $filename = $key . '.' . substr($header, strpos($header, '/')+1);
                }

                // Generate a temporary path to store the Base64 contents
                $tempFilePath = tempnam(sys_get_temp_dir(), $filename);

                // Store the contents using a stream, or by decoding manually
                if (Str::startsWith($base64Contents, 'data:') && count(explode(',', $base64Contents)) > 1) {
                    $source = fopen($base64Contents, 'r');
                    $destination = fopen($tempFilePath, 'w');

                    stream_copy_to_stream($source, $destination);

                    fclose($source);
                    fclose($destination);
                } else {
                    file_put_contents($tempFilePath, base64_decode($base64Contents, true));
                }

                $uploadedFile = new UploadedFile($tempFilePath, $filename, null, null, true);

                \Log::debug("Trait: uploadedfile ". $tempFilePath);
                $this->offsetUnset($key);                                                                                                                                                                                                                                                                                                                                               
                \Log::debug("Trait: encoded field \"$key\" removed" );
                
                //Inserting new file  to $this-files does not work so have to deal this after
                $this->offsetSet($key,$uploadedFile);
                \Log::debug("Trait:  field \"$key\" inserted as UplodedFile" );
    
            }, null, false);
        });
    }
}
/**
 * Loosely based on idea https://github.com/protonemedia/laravel-mixins/tree/master/src/Request
 * */