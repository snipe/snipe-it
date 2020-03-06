<?php

namespace App\Http\Requests;

use App\Models\SnipeModel;
use Intervention\Image\Facades\Image;
use enshrined\svgSanitize\Sanitizer;
use Storage;

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
            'image' => 'mimes:png,gif,jpg,jpeg,svg,bmp,svg+xml',
            'avatar' => 'mimes:png,gif,jpg,jpeg,svg,bmp,svg+xml',
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
    public function handleImages($item, $w = 550, $fieldname = 'image', $path = null)
    {

        $type = strtolower(class_basename(get_class($item)));

        if (is_null($path)) {
            $path =  str_plural($type);
        }

        \Log::debug('Image path is: '.$path);
        \Log::debug('Image fieldname is: '.$fieldname);



        if ($this->hasFile($fieldname)) {

            if (!config('app.lock_passwords')) {

                if (!Storage::disk('public')->exists($path)) Storage::disk('public')->makeDirectory($path, 775);

                $image = $this->file($fieldname);
                $ext = $image->getClientOriginalExtension();
                $file_name = $type.'-'.str_random(18).'.'.$ext;

                if ($image->getClientOriginalExtension()!='svg') {

                    $upload = Image::make($image->getRealPath())->resize(null, $w, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    // This requires a string instead of an object, so we use ($string)
                    Storage::disk('public')->put($path.'/'.$file_name, (string)$upload->encode());

                // If the file is an SVG, we need to clean it and NOT encode it
                } else {
                    $sanitizer = new Sanitizer();
                    $dirtySVG = file_get_contents($image->getRealPath());
                    $cleanSVG = $sanitizer->sanitize($dirtySVG);
                    Storage::disk('public')->put($path.'/'.$file_name, $cleanSVG);
                }

                // Remove current image if it exists and we're uploading a new one
                if (($item->{$fieldname}) && (Storage::disk('public')->exists($path.'/'.$item->{$fieldname}))) {
                    Storage::disk('public')->delete($path.'/'.$item->{$fieldname});
                } else {
                    \Log::debug('Could not delete old file. '.$path.'/'.$item->{$fieldname}.' does not exist?');
                }

                // Assign the new filename as the fieldname
                $item->{$fieldname} = $file_name;
            }

        // If the user isn't uploading anything new but wants to delete their old image, do so
        } elseif ($this->input('image_delete')=='1') {
            Storage::disk('public')->delete($path.'/'.$item->{$fieldname});
            $item->{$fieldname} = null;
        }

        return $item;
    }
}
