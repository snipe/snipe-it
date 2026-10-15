<?php

namespace App\Models\Traits;

use App\Enums\FileStorage;
use LogicException;

/**
 * Models with an `image` / `avatar` / `logo` column mix this in to
 * resolve their public upload directory via the FileStorage enum,
 * so call sites never pass raw string keys around.
 *
 * The using model declares its storage once:
 *
 *     class User extends SnipeModel
 *     {
 *         use HasImageUpload;
 *
 *         public static function fileStorage(): FileStorage
 *         {
 *             return FileStorage::Avatars;
 *         }
 *     }
 *
 *     $user->imageUploadPath();   // 'avatars/'
 *     $asset->imageUploadPath();  // 'assets/'
 *
 * This trait is for the common "one image per model" case.
 * Settings is an intentional outlier because its images (logo,
 * email_logo, favicon, default_avatar, etc.) live at different
 * paths including the root of `public/uploads/`, which does not fit
 * a single-dir resolver. Settings resolves its own paths explicitly
 * via SettingsController rather than using this trait.
 *
 * This is also separate from `HasUploads`, which handles the
 * Files-tab attachment relationship (not model-owned image fields).
 */
trait HasImageUpload
{
    /**
     * Return the FileStorage case for this model's image upload.
     * Must be in the public scope (`hasPublicScope() === true`).
     */
    abstract public static function fileStorage(): FileStorage;

    /**
     * Public upload directory for this model's image, with trailing
     * slash, suitable for appending a filename.
     */
    public function imageUploadPath(): string
    {
        $resource = static::fileStorage();
        $path = $resource->publicPath();
        if ($path === null) {
            throw new LogicException(
                static::class.' uses HasImageUpload but '.$resource->value.' has no public scope'
            );
        }

        return $path;
    }
}
