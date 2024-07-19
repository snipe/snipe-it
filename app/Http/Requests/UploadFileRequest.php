<?php

namespace App\Http\Requests;

use App\Http\Traits\ConvertsBase64ToFiles;
use enshrined\svgSanitize\Sanitizer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UploadFileRequest extends Request
{
    use ConvertsBase64ToFiles;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $max_file_size = \App\Helpers\Helper::file_upload_max_size();

        return [
          'file.*' => 'required|mimes:png,gif,jpg,svg,jpeg,doc,docx,pdf,txt,zip,rar,xls,xlsx,lic,xml,rtf,json,webp,avif|max:'.$max_file_size,
        ];
    }

    /**
     * Sanitizes (if needed) and Saves a file to the appropriate location
     * Returns the 'short' (storage-relative) filename
     *
     * TODO - this has a lot of similarities to UploadImageRequest's handleImage; is there
     *        a way to merge them or extend one into the other?
     */
    public function handleFile(string $dirname, string $name_prefix, $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $file_name = $name_prefix.'-'.str_random(8).'-'.str_slug(basename($file->getClientOriginalName(), '.'.$extension)).'.'.$file->guessExtension();


        Log::debug("Your filetype IS: ".$file->getMimeType());
        // Check for SVG and sanitize it
        if ($file->getMimeType() === 'image/svg+xml') {
            Log::debug('This is an SVG');
            Log::debug($file_name);

            $sanitizer = new Sanitizer();
            $dirtySVG = file_get_contents($file->getRealPath());
            $cleanSVG = $sanitizer->sanitize($dirtySVG);

            try {
                Storage::put($dirname.$file_name, $cleanSVG);
            } catch (\Exception $e) {
                Log::debug('Upload no workie :( ');
                Log::debug($e);
            }

        } else {
            $put_results = Storage::put($dirname.$file_name, file_get_contents($file));
            Log::debug("Here are the '$put_results' (should be 0 or 1 or true or false or something?)");
        }
        return $file_name;
    }
}
