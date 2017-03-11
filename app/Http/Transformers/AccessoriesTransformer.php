<?php
namespace App\Http\Transformers;

use App\Models\Accessory;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\Helper;

class AccessoriesTransformer
{

    public function transformAccessories (Collection $accessories, $total)
    {
        $array = array();
        foreach ($accessories as $accessory) {
            $array[] = self::transformAccessory($accessory);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformAccessory (Accessory $accessory)
    {
        $array = [
            'id' => $accessory->id,
            'name' => e($accessory->name),
            'company' => ($accessory->company) ? ['id' => $accessory->company->id,'name'=> e($accessory->company->name)] : '',
            'manufacturer' => ($accessory->manufacturer) ? ['id' => $accessory->manufacturer->id,'name'=> e($accessory->manufacturer->name)] : '',
            'model_number' => ($accessory->model_number) ? e($accessory->model_number) : null,
            'category' => ($accessory->category) ? ['id' => $accessory->category->id,'name'=> e($accessory->category->name)] : '',
            'location' => ($accessory->location) ? ['id' => $accessory->location->id,'name'=> e($accessory->location->name)] : '',
            'notes' => ($accessory->notes) ? e($accessory->notes) : null,
            'qty' => ($accessory->qty) ? e($accessory->qty) : null,
            'purchase_date' => ($accessory->purchase_date) ? Helper::getFormattedDateObject($accessory->purchase_date, 'date') : null,
            'purchase_cost' => ($accessory->purchase_cost) ? e($accessory->purchase_cost) : null,
            'order_number' => ($accessory->order_number) ? e($accessory->order_number) : null,
            'min_qty' => ($accessory->min_amt) ? e($accessory->min_amt) : null,
            'remaining_qty' => $accessory->numRemaining(),
            'created_at' => Helper::getFormattedDateObject($accessory->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($accessory->updated_at, 'datetime'),

        ];

        $permissions_array['available_actions'] = [
            'checkout' => Gate::allows('checkout', Accessory::class) ? true : false,
            'checkin' =>  false,
            'update' => Gate::allows('update', Accessory::class) ? true : false,
            'delete' => Gate::allows('delete', Accessory::class) ? true : false,
        ];

        $permissions_array['user_can_checkout'] = false;

        if ($accessory->numRemaining() > 0) {
            $permissions_array['user_can_checkout'] = true;
        }

        $array += $permissions_array;

        return $array;
    }


    public function transformCheckedoutAccessories (Collection $accessories_users, $total)
    {

        $array = array();
        foreach ($accessories_users as $user) {
            $array[] = (new UsersTransformer)->transformUser($user);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }



}
