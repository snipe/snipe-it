<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\SnipeModel;
use enshrined\svgSanitize\Sanitizer;
use Intervention\Image\Facades\Image;

class FileUploadRequest extends Request
{
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
            'file.*' => 'required|mimes:png,gif,jpg,svg,jpeg,doc,docx,pdf,txt,zip,rar,xls,lic|max:'.$max_file_size,
        ];
    }

    public function response(array $errors)
    {
        return $this->redirector->back()->withInput()->withErrors($errors, $this->errorBag);
    }

    /**
     * Handle and store any images attached to request
     * @param SnipeModel $item Item the image is associated with
     * @param String $path  location for uploaded images, defaults to uploads/plural of item type.
     * @return SnipeModel        Target asset is being checked out to.
     */
    public function handleFile($item,$path = null)
    {

        $type = strtolower(class_basename(get_class($item)));

        if (is_null($path)) {
            $path =  str_plural($type);
        }

        \Log::debug('Trying to upload to '. $path);

        if ($this->hasFile('invoice_file')) {

            if (!is_dir($path)) {
                \Log::debug($path.' does not exist');
                mkdir($path);
            }
            $file = $this->file('invoice_file');
            $filename = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $file_name = $filename.'-'.str_random(6).'.'.$ext;
            \Log::debug('File name will be: '.$file_name);

            \Log::debug('Trying to upload to: '.$path.'/'.$file_name);

//            $file->store($path.'/'.$file_name);
            $cleanSVG = file_get_contents($file->getRealPath());
            file_put_contents($path.'/'.$file_name, $cleanSVG);

            // Remove Current image if exists
            if (($item->invoice_file) && (file_exists($path.'/'.$item->invoice_file))) {
                try {
                    unlink($path.'/'.$item->invoice_file);
                } catch (\Exception $e) {
                    \Log::debug($e);
                }
            }

            $item->invoice_file = $file_name;

        } elseif ($this->input('file_delete')=='1') {

            try {
                unlink($path.'/'.$item->invoice_file);
            } catch (\Exception $e) {
                \Log::debug($e);
            }

            $item->invoice_file = null;
        }
        return $item;
    }
}
