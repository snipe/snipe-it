<?php

namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Helpers\StorageHelper;
use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\License;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;

class UploadedFilesTransformer
{
    public function transformFiles(Collection $files, $total)
    {
        $array = [];
        foreach ($files as $file) {
            $array[] = self::transformFile($file);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }


    public function transformFile(Actionlog $file)
    {
        $snipeModel = $file->item_type;



        \Log::error(StorageHelper::getFiletype($file->uploads_file_path()));
        $array = [
            'id' => (int) $file->id,
            'icon' => Helper::filetype_icon($file->filename),
            'filename' => e($file->filename),
            'inline' => StorageHelper::allowSafeInline($file->uploads_file_path()),
            'filetype' => StorageHelper::getFiletype($file->uploads_file_path()),
            'url' => $file->uploads_file_url(),
            'created_by' => ($file->adminuser) ? [
                'id' => (int) $file->adminuser->id,
                'name'=> e($file->adminuser->present()->fullName),
            ] : null,
            'note' => e($file->note),
            'created_at' => Helper::getFormattedDateObject($file->created_at, 'datetime'),
            'deleted_at' => Helper::getFormattedDateObject($file->deleted_at, 'datetime'),
        ];

        $permissions_array['available_actions'] = [
            'delete' => (Gate::allows('update', $snipeModel) && ($file->deleted_at == '')),
        ];

        $array += $permissions_array;
        return $array;
    }


}
