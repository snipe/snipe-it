<?php
namespace App\Http\Transformers;

use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\Collection;
use Gate;
use App\Helpers\Helper;

class ManufacturersTransformer
{

    public function transformManufacturers (Collection $manufacturers, $total)
    {
        $array = array();
        foreach ($manufacturers as $manufacturer) {
            $array[] = self::transformManufacturer($manufacturer);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformManufacturer (Manufacturer $manufacturer = null)
    {
        if ($manufacturer) {

            $array = [
                'id' => (int) $manufacturer->id,
                'name' => e($manufacturer->name),
                'url' => e($manufacturer->url),
                'image' =>   ($manufacturer->image) ? app('manufacturers_upload_url').e($manufacturer->image) : null,
                'support_url' => e($manufacturer->support_url),
                'support_phone' => e($manufacturer->support_phone),
                'support_email' => e($manufacturer->support_email),
                'assets_count' => (int) $manufacturer->assets_count,
                'licenses_count' => (int) $manufacturer->licenses_count,
                'consumables_count' => (int) $manufacturer->consumables_count,
                'accessories_count' => (int) $manufacturer->accessories_count,
                'created_at' => Helper::getFormattedDateObject($manufacturer->created_at, 'datetime'),
                'updated_at' => Helper::getFormattedDateObject($manufacturer->updated_at, 'datetime'),
            ];

            $permissions_array['available_actions'] = [
                'update' => Gate::allows('update', Manufacturer::class) ? true : false,
                'delete' => Gate::allows('delete', Manufacturer::class) ? true : false,
            ];

            $array += $permissions_array;

            return $array;
        }


    }



}
