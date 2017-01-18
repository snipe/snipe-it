<?php
namespace App\Http\Transformers;

use App\Models\Statuslabel;
use Illuminate\Database\Eloquent\Collection;

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
            'color' => e($statuslabel->color),
            'show_in_nav' => ($statuslabel->show_in_nav=='1') ? true : false,
            'created_at' => $statuslabel->created_at,
            'updated_at' => $statuslabel->updated_at,
        ];

        return $array;
    }

    public function transformStatuslabelsDatatable($users) {
        return (new DatatablesTransformer)->transformDatatables($users);
    }



}
