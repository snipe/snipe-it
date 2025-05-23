<?php

namespace App\Http\Requests;

use App\Http\Traits\ConvertsBase64ToFiles;
use enshrined\svgSanitize\Sanitizer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use \App\Helpers\Helper;

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
        $max_file_size = Helper::file_upload_max_size();

        return [
          'file.*' => 'required|mimes:png,gif,jpg,svg,jpeg,doc,docx,pdf,txt,zip,rar,xls,xlsx,lic,xml,rtf,json,webp,avif|max:'.$max_file_size,
        ];
    }

    /**
     * Sanitizes (if needed) and Saves a file to the appropriate location
     * Returns the 'short' (storage-relative) filename
     */
    public function handleFile(string $dirname, string $name_prefix, $file): string
    {

        $file_name = $name_prefix.'-'.str_random(8).'-'.str_replace(' ', '-', $file->getClientOriginalName());

        // Check for SVG and sanitize it
        if ($file->getMimeType() === 'image/svg+xml') {
            $uploaded_file = $this->handleSVG($file);
        } else {
            $uploaded_file = file_get_contents($file);
        }

        try {
            Storage::put($dirname.$file_name, $uploaded_file);
        } catch (\Exception $e) {
            Log::debug($e);
        }

        return $file_name;
    }

    public function handleSVG($file) {
        $sanitizer = new Sanitizer();
        $dirtySVG = file_get_contents($file->getRealPath());
        return $sanitizer->sanitize($dirtySVG);
    }


    /**
     * Get the validation error messages that apply to the request, but
     * replace the attribute name with the name of the file that was attempted and failed
     * to make it clearer to the user which file is the bad one.
     * @return array
     */
    public function attributes(): array
    {
        $attributes = [];

        if ($this->file) {
            for ($i = 0; $i < count($this->file); $i++) {
                $attributes['file.'.$i] = $this->file[$i]->getClientOriginalName();
            }
        }

        return $attributes;

    }
}
