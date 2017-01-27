<?php
namespace App\Http\Transformers;

use App\Models\Consumable;
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\Helper;

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
        $transformed = [
            'category'      => ($consumable->category) ? ['id' => $consumable->category->id, 'name' => $consumable->category->name] : null,
            'company'   => ($consumable->company) ? ['id' => $consumable->company->id, 'name' => $consumable->company->name] : null,
            'id'            => $consumable->id,
            'item_no'       => $consumable->item_no,
            'location'      => ($consumable->location) ? ['id' => $consumable->location->id, 'name' => $consumable->location->name] : null,
            'manufacturer'  => ($consumable->manufacturer) ? ['id' => $consumable->manufacturer->id, 'name' => $consumable->manufacturer->name] : null,
            'min_amt'       => $consumable->min_amt,
            'model_number'  => $consumable->model_number,
            'name'          => $consumable->name,
            'numRemaining'  => $consumable->numRemaining(),
            'order_number'  => $consumable->order_number,
            'purchase_cost'  => Helper::formatCurrencyOutput($consumable->purchase_cost),
            'purchase_date'  => $consumable->purchase_date,
            'qty'           => $consumable->qty,
        ];
        return $transformed;
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
