<?php
namespace App\Http\Transformers;

use App\Models\Insurance;
use Illuminate\Database\Eloquent\Collection;
use Gate;
use App\Helpers\Helper;

class InsuranceTransformer
{

    public function transformInsurances (Collection $insurances, $total)
    {
        $array = array();
        foreach ($insurances as $insurance) {
            $array[] = self::transformInsurance($insurance);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformInsurance (Insurance $insurance = null)
    {
        if ($insurance) {

            $array = [
                'id' => (int) $insurance->id,
                'name' => e($insurance->name),
                'notes' => e($insurance->notes),
                'started_at' => Helper::getFormattedDateObject($insurance->started_at, 'datetime'),
                'ended_at' => Helper::getFormattedDateObject($insurance->ended_at, 'datetime'),
                'created_at' => Helper::getFormattedDateObject($insurance->created_at, 'datetime'),
                'deleted_at' => Helper::getFormattedDateObject($insurance->deleted_at, 'datetime'),
            ];

            $permissions_array['available_actions'] = [
                'update' => (($insurance->deleted_at=='') && (Gate::allows('update', Insurance::class))) ? true : false,
                'restore' => (($insurance->deleted_at!='') && (Gate::allows('create', Insurance::class))) ? true : false,
                'delete' => (Gate::allows('delete', Insurance::class)&& ($insurance->deleted_at=='')) ? true : false,
            ];

            $array += $permissions_array;

            return $array;
        }


    }



}
