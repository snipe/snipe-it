<?php
namespace App\Http\Transformers;

use App\Models\Location;


class DatatablesTransformer
{

    public function transformDatatables($objects)
    {
        $objects_array['rows'] = $objects;
        $objects_array['total'] = count($objects);
        return $objects_array;
    }
}
