<?php
namespace App\Http\Transformers;

use App\Models\InventoryStatuslabel;
use App\Models\Statuslabel;
use Illuminate\Database\Eloquent\Collection;
use Gate;
use App\Helpers\Helper;

class InventoryStatuslabelsTransformer
{

    public function transformInventoryStatuslabels (Collection $statuslabels, $total)
    {
        $array = array();
        foreach ($statuslabels as $statuslabel) {
            $array[] = self::transformInventoryStatuslabel($statuslabel);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformInventoryStatuslabel (InventoryStatuslabel $statuslabel)
    {
        $array = [
            'id' => (int) $statuslabel->id,
            'name' => e($statuslabel->name),
            'success' => e($statuslabel->success),
            'color' => ($statuslabel->color) ? e($statuslabel->color) : null,
            'notes' => e($statuslabel->notes),
            'created_at' => Helper::getFormattedDateObject($statuslabel->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($statuslabel->updated_at, 'datetime'),
        ];

        $permissions_array['available_actions'] = [
            'update' => Gate::allows('update', Statuslabel::class) ? true : false,
            'delete' => (Gate::allows('delete', Statuslabel::class) && ($statuslabel->assets_count == 0)) ? true : false,
        ];
        $array += $permissions_array;

        return $array;
    }



}
