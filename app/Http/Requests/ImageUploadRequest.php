<?php

namespace App\Http\Requests;

use App\Helpers\Helper;
use App\Http\Traits\ConvertsBase64ToFiles;
use App\Models\SnipeModel;
use enshrined\svgSanitize\Sanitizer;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\Facades\Image;

class ImageUploadRequest extends Request
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
        // Dimensions caps run via getimagesize() (header-read only, no raster
        // decode), so they fire before Image::make() gets to allocate a
        // decompressed pixel buffer. Without them, a tiny solid-color PNG
        // with large declared dimensions decodes to many hundreds of
        // megabytes of RGBA before resize() ever runs. SVGs are hard-skipped
        // by the dimensions validator - they go through the sanitizer,
        // not GD/ImageMagick.
        //
        // 4096x4096 (16.7MP) caps RGBA raster at ~64MB. Combined with the
        // resize-target buffer plus GD / Imagick overhead, total peak stays
        // comfortably under a 256MB worker memory limit. The earlier
        // 10000x10000 cap was per-axis but the pixel budget (100MP ->
        // ~400MB raster) could still overrun a worker on a highly-compressed
        // image that passed the file-size check (reported by Wojciech
        // Ciemski post-GHSA-2q8x-3vjh-f757 patch).
        //
        // Laravel's `max:` rule treats its argument as KIBIBYTES for file
        // validators, not bytes. file_upload_max_size() returns bytes, so
        // divide by 1024 and round up before interpolating or the rule is
        // 1024x too permissive.
        $max_kib = (int) ceil(Helper::file_upload_max_size() / 1024);

        return [
            'image' => 'mimes:png,gif,jpg,jpeg,svg,bmp,svg+xml,webp,avif|max:'.$max_kib.'|dimensions:max_width=4096,max_height=4096',
            'avatar' => 'mimes:png,gif,jpg,jpeg,svg,bmp,svg+xml,webp,avif|max:'.$max_kib.'|dimensions:max_width=4096,max_height=4096',
            'favicon' => 'mimes:png,gif,jpg,jpeg,svg,bmp,svg+xml,webp,image/x-icon,image/vnd.microsoft.icon,ico|max:'.$max_kib.'|dimensions:max_width=1024,max_height=1024',
        ];
    }

    /**
     * Per-field overrides for the `max:` rule's validation message. The
     * default Laravel message interpolates the rule argument raw, which
     * reads as "greater than 2048 kilobytes" with our byte-to-KiB
     * conversion. Swap in `file_upload_max_size_readable()` output
     * ("2M", "20M", "2G") so the user-facing message matches the
     * configured PHP limit without exposing the raw KiB value.
     */
    public function messages(): array
    {
        $max = Helper::file_upload_max_size_readable();

        return [
            'image.max' => trans('validation.image_file_too_large', ['max' => $max]),
            'avatar.max' => trans('validation.image_file_too_large', ['max' => $max]),
            'favicon.max' => trans('validation.image_file_too_large', ['max' => $max]),
        ];
    }

    public function response(array $errors)
    {
        return $this->redirector->back()->withInput()->withErrors($errors, $this->errorBag);
    }

    /**
     * Fields that should be traited from base64 to files
     */
    protected function base64FileKeys(): array
    {
        /**
         * image_source is here just legacy reasons. Api\AssetController
         * had it once to allow encoded image uploads.
         */
        return [
            'avatar' => 'auto',
            'image' => 'auto',
            'image_source' => 'auto',
        ];
    }

    /**
     * Handle and store any images attached to request
     *
     * @param  SnipeModel  $item  Item the image is associated with
     * @param  string  $path  location for uploaded images, defaults to uploads/plural of item type.
     * @return SnipeModel Target asset is being checked out to.
     */
    public function handleImages($item, $w = 600, $form_fieldname = 'image', $path = null, $db_fieldname = 'image')
    {

        $type = class_basename(get_class($item));

        if (is_null($path)) {

            $path = strtolower(str_plural($type));

            if ($type == 'AssetModel') {
                $path = 'models';
            }

            if ($type == 'user') {
                $path = 'avatars';
            }

        }

        // SettingsController passes '' to mean "disk root".
        // Normalize and use a single prefix so we never have a leading-slash
        // key (S3 stores `/foo.png` and `foo.png` as distinct objects) and
        // never HEAD an empty key (which S3's HeadObject validator rejects
        // outright — the bug behind #18267).
        $path = trim((string) $path, '/');
        $prefix = $path === '' ? '' : $path.'/';

        // No pre-emptive makeDirectory. S3 has no directories to
        // create (flat namespace), and LocalFilesystemAdapter::write()
        // calls ensureDirectoryExists() before writing, so the parent
        // is auto-created on the local disk anyway.
        if ($this->offsetGet($form_fieldname) instanceof UploadedFile) {
            $image = $this->offsetGet($form_fieldname);
        } elseif ($this->hasFile($form_fieldname)) {
            $image = $this->file($form_fieldname);
        }

        if ((isset($image)) && ($image != '')) {

            $ext = $image->guessExtension();
            $file_name = $type.'-'.$form_fieldname.($item->id ?? '-'.$item->id).'-'.str_random(10).'.'.$ext;

            // Track whether the new file actually landed on disk. Storage::put
            // can return false without throwing (disks default to non-throwing
            // mode). Before, the ordering was put -> deleteExistingImage ->
            // reassign, all unconditional, so a failed put still destroyed
            // the current image and left the model referencing a file that
            // was never written. Keep the old image intact unless we confirm
            // the new one is there.
            $wroteNewFile = false;

            if (($image->getMimeType() == 'image/vnd.microsoft.icon') || ($image->getMimeType() == 'image/x-icon') || ($image->getMimeType() == 'image/avif') || ($image->getMimeType() == 'image/webp')) {
                // If the file is an icon, webp or avif, we need to just move it since gd doesn't support resizing
                // icons or avif, and webp support and needs to be compiled into gd for resizing to be available
                $wroteNewFile = (bool) Storage::disk('public')->put($prefix.$file_name, file_get_contents($image));

            } elseif ($image->getMimeType() == 'image/svg+xml') {
                // If the file is an SVG, we need to clean it and NOT encode it
                $sanitizer = new Sanitizer;
                $dirtySVG = file_get_contents($image->getRealPath());
                $cleanSVG = $sanitizer->sanitize($dirtySVG);

                try {
                    $wroteNewFile = (bool) Storage::disk('public')->put($prefix.$file_name, $cleanSVG);
                } catch (\Exception $e) {
                    Log::debug($e);
                }
            } else {

                try {
                    $upload = Image::make($image->getRealPath())->setFileInfoFromPath($image->getRealPath())->resize(null, $w, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->orientate();

                } catch (NotReadableException $e) {
                    Log::debug($e);
                    $validator = Validator::make([], []);
                    $validator->errors()->add($form_fieldname, trans('general.unaccepted_image_type', ['mimetype' => $image->getClientMimeType()]));

                    throw new ValidationException($validator);
                }

                // This requires a string instead of an object, so we use ($string)
                $wroteNewFile = (bool) Storage::disk('public')->put($prefix.$file_name, (string) $upload->encode());

            }

            if ($wroteNewFile) {
                // Only touch the existing image and the model reference AFTER
                // confirming the new file is on disk. deleteExistingImage
                // itself now also refuses to null the model when the delete
                // fails, so a partial cleanup does not leave the model
                // pointing at a phantom file either way.
                $item = $this->deleteExistingImage($item, $path, $db_fieldname);
                $item->{$db_fieldname} = $file_name;
            } else {
                Log::warning('Image upload failed to write to disk; keeping existing image reference intact.', [
                    'item_type' => $type,
                    'item_id' => $item->id ?? null,
                    'target_path' => $prefix.$file_name,
                ]);
            }

            // If the user isn't uploading anything new but wants to delete their old image, do so
        } elseif ($this->input('image_delete') == '1') {
            $item = $this->deleteExistingImage($item, $path, $db_fieldname);
        }

        return $item;
    }

    public function deleteExistingImage($item, $path = null, $db_fieldname = 'image')
    {

        if ($item->{$db_fieldname} != '') {
            // Absolute http(s) URLs (OAuth-sourced avatars from Google,
            // Microsoft, Gravatar, etc.) do not point at anything on this
            // disk and early return.
            if (preg_match('#^https?://#i', (string) $item->{$db_fieldname}) === 1) {
                $item->{$db_fieldname} = null;

                return $item;
            }

            try {
                // Same path normalization as handleImages. Branding callers
                // pass '' for the disk root, and we don't want to produce a
                // leading-slash key on S3.
                $path = trim((string) $path, '/');

                // Defense in depth against a stored value that carries
                // path traversal (e.g. `../barcodes/target.png`). Every
                // sanctioned writer of these image columns produces a bare
                // filename, but a legacy row or a future writer that skips
                // that step must not reach the delete with a
                // composable-into-cross-directory key.
                $filename = basename((string) $item->{$db_fieldname});
                $key = $path === '' ? $filename : $path.'/'.$filename;
                $deleted = Storage::disk('public')->delete($key);

                // Only null the model reference if the delete actually
                // succeeded.
                if ($deleted) {
                    $item->{$db_fieldname} = null;
                } else {
                    Log::warning('Storage delete returned false; keeping model reference so operators can retry.', [
                        'item_type' => class_basename(get_class($item)),
                        'item_id' => $item->id ?? null,
                        'key' => $key,
                    ]);
                }
            } catch (\Exception $e) {
                Log::debug($e);
            }
        }

        return $item;
    }
}
