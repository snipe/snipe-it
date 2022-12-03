<?php

namespace Modules\RentOrders\Http\Transformers;

use App\Helpers\Helper;
use App\Http\Transformers\DatatablesTransformer;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Modules\RentOrders\Entities\RentOrder;
use Modules\RentOrders\Entities\RentOrderStatus;

class RentOrdersTransformer
{
    public function transformRentOrders(Collection $rentOrders, $total)
    {
        $array = [];
        foreach ($rentOrders as $rentOrder) {
            $array[] = self::transformRentOrder($rentOrder);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformRentOrder(RentOrder $rentOrder = null)
    {
        if ($rentOrder) {
            $array = [
                'id' => (int)$rentOrder->id,
                "created_by" => User::find($rentOrder->created_by),
                "assigned_to" => User::find($rentOrder->assigned_to),
                "status" => RentOrderStatus::find($rentOrder->status),
                'created_at' => Helper::getFormattedDateObject($rentOrder->created_at, 'datetime'),
                'updated_at' => Helper::getFormattedDateObject($rentOrder->updated_at, 'datetime'),
            ];

            $permissions_array['available_actions'] = [
//                'update' => Gate::allows('update', Category::class),
//                'delete' => $rentOrder->isDeletable(),
                'update' => true,
                'delete' => true,
            ];

            $array += $permissions_array;

            return $array;
        }
    }
}