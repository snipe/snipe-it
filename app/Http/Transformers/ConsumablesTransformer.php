<?php
namespace App\Http\Transformers;

use App\Models\Consumable;
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\Helper;
use Gate;

class ConsumablesTransformer
{

    public function transformConsumables (Collection $consumables, $total)
    {
        $array = array();
        foreach ($consumables as $consumable) {
            $array[] = self::transformConsumable($consumable);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformConsumable (Consumable $consumable)
    {
        $array = [
            'id'            => (int) $consumable->id,
            'name'          => e($consumable->name),
            'image' =>   ($consumable->image) ? e(url('/').'/uploads/consumables/'.e($consumable->image)) : null,
            'category'      => ($consumable->category) ? ['id' => $consumable->category->id, 'name' => e($consumable->category->name)] : null,
            'company'   => ($consumable->company) ? ['id' => (int) $consumable->company->id, 'name' => e($consumable->company->name)] : null,
            'item_no'       => e($consumable->item_no),
            'location'      => ($consumable->location) ? ['id' => (int) $consumable->location->id, 'name' => e($consumable->location->name)] : null,
            'manufacturer'  => ($consumable->manufacturer) ? ['id' => (int) $consumable->manufacturer->id, 'name' => e($consumable->manufacturer->name)] : null,
            'min_amt'       => (int) $consumable->min_amt,
            'model_number'  => ($consumable->model_number!='') ? e($consumable->model_number) : null,
            'remaining'  => $consumable->numRemaining(),
            'order_number'  => e($consumable->order_number),
            'purchase_cost'  => Helper::formatCurrencyOutput($consumable->purchase_cost),
            'purchase_date'  => Helper::getFormattedDateObject($consumable->purchase_date, 'date'),
            'qty'           => (int) $consumable->qty,
            'created_at' => Helper::getFormattedDateObject($consumable->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($consumable->updated_at, 'datetime'),
        ];

        $permissions_array['user_can_checkout'] = false;

        if ($consumable->numRemaining() > 0) {
            $permissions_array['user_can_checkout'] = true;
        }

        $permissions_array['available_actions'] = [
            'checkout' => Gate::allows('checkout', Consumable::class) ? true : false,
            'checkin' => Gate::allows('checkin', Consumable::class) ? true : false,
            'update' => Gate::allows('update', Consumable::class) ? true : false,
            'delete' => Gate::allows('delete', Consumable::class) ? true : false,
        ];
        $array += $permissions_array;
        return $array;
    }


    public function transformCheckedoutConsumables (Collection $consumables_users, $total)
    {

        $array = array();
        foreach ($consumables_users as $user) {
            $array[] = (new UsersTransformer)->transformUser($user);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }



}
