<?php
namespace App\Http\Transformers;

use App\Models\Component;
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\Helper;
use Gate;

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
        $array = [

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
            'purchase_date' =>  Helper::getFormattedDateObject($component->purchase_date, 'date'),
            'purchase_cost' => Helper::formatCurrencyOutput($component->purchase_cost),
            'remaining'  => $component->numRemaining(),
            'company'   => ($component->company) ?
                [
                    'id' => $component->company->id,
                    'name' => e($component->company->name)
                ] : null,
            'created_at' => Helper::getFormattedDateObject($component->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($component->updated_at, 'datetime'),

        ];

        $permissions_array['available_actions'] = [
            'checkout' => Gate::allows('checkout', Component::class) ? true : false,
            'checkin' => Gate::allows('checkin', Component::class) ? true : false,
            'update' => Gate::allows('update', Component::class) ? true : false,
            'delete' => Gate::allows('delete', Component::class) ? true : false,
        ];
        $array += $permissions_array;

        return $array;
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
