<?php
namespace App\Http\Transformers;

use App\Models\Statuslabel;
use Illuminate\Database\Eloquent\Collection;
use Gate;

class StatuslabelsTransformer
{

    public function transformStatuslabels (Collection $statuslabels)
    {
        $array = array();
        foreach ($statuslabels as $statuslabel) {
            $array[] = self::transformStatuslabel($statuslabel);
        }
        return (new DatatablesTransformer)->transformDatatables($array);
    }

    public function transformStatuslabel (Statuslabel $statuslabel)
    {
        $array = [
            'id' => e($statuslabel->id),
            'name' => e($statuslabel->name),
            'type' => $statuslabel->getStatuslabelType(),
            'color' => ($statuslabel->color) ? e($statuslabel->color) : null,
            'show_in_nav' => ($statuslabel->show_in_nav=='1') ? true : false,
            'notes' => e($statuslabel->notes),
            'created_at' => $statuslabel->created_at,
            'updated_at' => $statuslabel->updated_at,
        ];

        $permissions_array['available_actions'] = [
            'edit' => Gate::allows('admin') ? true : false,
            'delete' => Gate::allows('admin') ? true : false,
        ];
        $array += $permissions_array;

        return $array;
    }



}
