<?php

namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\AssetModel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

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


        // This will be used later as we extend out this transformer to handle more types of uploads
        if ($file->item_type == Asset::class) {
            $file_url = route('show/assetfile', [$file->item_id, $file->id]);
        } elseif ($file->item_type == AssetModel::class) {
            $file_url = route('show/modelfile', [$file->item_id, $file->id]);
        }

        $array = [
            'id' => (int) $file->id,
            'filename' => e($file->filename),
            'url' => $file_url,
            'created_by' => ($file->adminuser) ? [
                'id' => (int) $file->adminuser->id,
                'name'=> e($file->adminuser->present()->fullName),
            ] : null,
            'note' => e($file->note),
            'created_at' => Helper::getFormattedDateObject($file->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($file->updated_at, 'datetime'),
            'deleted_at' => Helper::getFormattedDateObject($file->deleted_at, 'datetime'),
        ];

        $permissions_array['available_actions'] = [
            'delete' => (Gate::allows('update', $snipeModel) && ($file->deleted_at == '')),
        ];

        $array += $permissions_array;
        return $array;
    }

    public function transformFilesArray(Collection $files, $total)
    {
        $array = [];
        foreach ($files as $file) {
            $array[] = self::transformFile($file);
        }

        return $array;
    }

}
