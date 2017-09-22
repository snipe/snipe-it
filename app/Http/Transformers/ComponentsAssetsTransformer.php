<?php
namespace App\Http\Transformers;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Transformers\UsersTransformer;
use Gate;


class ComponentsAssetsTransformer
{
    public function transformAssets (Collection $assets, $total)
    {
        $array = array();
        foreach ($assets as $asset) {
            $array[] = self::transformAsset($asset);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }


    public function transformAsset (Asset $asset)
    {
        $array = [
            'id' => $asset->id,
            'name' => e($asset->name),
            'created_at' => $asset->created_at->format('Y-m-d'),
            'qty' => $asset->components()->count(),
            'user_can_checkout' => $asset->availableForCheckout(),
        ];

        $permissions_array['available_actions'] = [
            'checkout' => Gate::allows('checkout', Asset::class) ? true : false,
            'checkin' => Gate::allows('checkin', Asset::class) ? true : false,
            'update' => Gate::allows('update', Asset::class) ? true : false,
            'delete' => Gate::allows('delete', Asset::class) ? true : false,
        ];



        $array += $permissions_array;

        if ($asset->model->fieldset) {
            foreach ($asset->model->fieldset->fields as $field) {
                $fields_array = [$field->name => $asset->{$field->convertUnicodeDbSlug()}];
                $array += $fields_array;
            }
       }

        return $array;
    }

    public function transformAssetsDatatable ($assets) {
        return (new DatatablesTransformer)->transformDatatables($assets);
    }
}
