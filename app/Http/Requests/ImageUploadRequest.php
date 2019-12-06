<?php

namespace App\Http\Requests;

use App\Models\SnipeModel;
use Intervention\Image\Facades\Image;
use enshrined\svgSanitize\Sanitizer;

class ImageUploadRequest extends Request
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
        return [
            'image' => 'mimes:png,gif,jpg,jpeg,svg',
            'avatar' => 'mimes:png,gif,jpg,jpeg,svg',
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
    public function handleImages($item, $w = 600, $path = null)
    {

        $type = strtolower(class_basename(get_class($item)));

        if (is_null($path)) {
            $path =  str_plural($type);
        }

        \Log::debug('Trying to upload to '. $path);

        if ($this->hasFile('image')) {

            if (!config('app.lock_passwords')) {


                if (!is_dir($path)) {
                    \Log::debug($path.' does not exist');
                    mkdir($path);
                }

                $image = $this->file('image');
                $ext = $image->getClientOriginalExtension();
                $file_name = $type.'-'.str_random(18).'.'.$ext;
                \Log::debug('File name will be: '.$file_name);

                if ($image->getClientOriginalExtension()!=='svg') {
                    \Log::debug('Not an SVG - resize');
                    \Log::debug('Trying to upload to: '.$path.'/'.$file_name);
                    $upload = Image::make($image->getRealPath())->resize(null, $w, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($path.'/'.$file_name);
                } else {
                    \Log::debug('This is an SVG');
                    $sanitizer = new Sanitizer();
                    $dirtySVG = file_get_contents($image->getRealPath());
                    $cleanSVG = $sanitizer->sanitize($dirtySVG);

                    try {
                        \Log::debug('Trying to upload to: '.$path.'/'.$file_name);
                        file_put_contents($path.'/'.$file_name, $cleanSVG);
                    } catch (\Exception $e) {
                        \Log::debug($e);
                    }
                }


                // Remove Current image if exists
                if (($item->image) && (file_exists($path.'/'.$item->image))) {
                    try {
                        unlink($path.'/'.$item->image);
                    } catch (\Exception $e) {
                        \Log::debug($e);
                    }
                }

                $item->image = $file_name;
            }

        } elseif ($this->input('image_delete')=='1') {

            try {
                unlink($path.'/'.$item->image);
            } catch (\Exception $e) {
                \Log::debug($e);
            }

            $item->image = null;
        }
        return $item;
    }
}