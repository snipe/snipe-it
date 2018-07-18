<?php

namespace App\Http\Requests;

use App\Models\SnipeModel;
use Intervention\Image\Facades\Image;

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
    public function handleImages($item, $path = null)
    {

        if ($this->hasFile('image')) {
            if (!config('app.lock_passwords')) {
                if(is_null($path)) {
                    $type = strtolower(class_basename(get_class($item)));
                    $plural = str_plural($type);
                    $path = public_path('/uploads/'.$plural);
                }
                $image = $this->file('image');
                $ext = $image->getClientOriginalExtension();
                $file_name = $type.'-'.str_random(18).'.'.$ext;
                if ($image->getClientOriginalExtension()!='svg') {
                    Image::make($image->getRealPath())->resize(null, 250, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($path.'/'.$file_name);
                } else {
                    $image->move($path, $file_name);
                }

                // Remove Current image if exists.
                if (($item->image) && (file_exists($path.'/'.$item->image))) {
                    unlink($path.'/'.$item->image);
                }

                $item->image = $file_name;
            }
        } elseif ($this->input('image_delete')=='1') {
            $item->image = null;
        }
        return $item;
    }
}
