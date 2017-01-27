<?php
namespace App\Http\Transformers;

use App\Models\Component;
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\Helper;

class ComponentsTransformer
{

    public function transformComponents (Collection $components, $total)
    {
        $array = array();
        foreach ($components as $component) {
            $array[] = self::transformComponent($component);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformComponent (Component $component)
    {
        $transformed = [

            'id'            => $component->id,
            'name'          => e($component->name),
            'serial_number' => e($component->serial),
            'location'      => ($component->location) ?
                [
                    'id' => $component->location->id,
                    'name' => $component->location->name
                ] : null,
            'qty'           => number_format($component->qty),
            'min_amt'       => e($component->min_amt),
            'category'      => ($component->category) ?
                [
                    'id' => $component->category->id,
                    'name' => e($component->category->name)
                ] : null,
            'order_number'  => e($component->order_number),
            'purchase_date' => $component->purchase_date,
            'purchase_cost' => Helper::formatCurrencyOutput($component->purchase_cost),
            'remaining'  => $component->numRemaining(),
            'company'   => ($component->company) ?
                [
                    'id' => $component->company->id,
                    'name' => e($component->company->name)
                ] : null,

        ];
        return $transformed;
    }


    public function transformCheckedoutComponents (Collection $components_users, $total)
    {

        $array = array();
        foreach ($components_users as $user) {
            $array[] = (new UsersTransformer)->transformUser($user);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }



}
