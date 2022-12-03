<?php

namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Accessory;
use App\Models\PurchaseOrder;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class PurchaseTransformer
{
    public function transformPurchases(Collection $purchases, $total)
    {
        $array = [];
        foreach ($purchases as $pur) {
            $array[] = self::transformPurchase($pur);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformPurchase(PurchaseOrder $pur)
    {
        $array = [
            'id' => $pur->id,
            'name' => e($pur->name),
            'user' => ($pur->user) ? ['id' => $pur->user->id, 'name' => e($pur->user->name)] : null,
            'state' => ($pur->state) ? (int) $pur->state : null,
            'created_at' => Helper::getFormattedDateObject($pur->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($pur->updated_at, 'datetime'),

        ];

        // $permissions_array['available_actions'] = [
        //     'checkout' => Gate::allows('checkout', Accessory::class),
        //     'checkin' =>  false,
        //     'update' => Gate::allows('update', Accessory::class),
        //     'delete' => Gate::allows('delete', Accessory::class),
        // ];

        // $permissions_array['user_can_checkout'] = false;

        // if ($accessory->numRemaining() > 0) {
        //     $permissions_array['user_can_checkout'] = true;
        // }

        // $array += $permissions_array;

        return $array;
    }

    public function transformCheckedoutAccessory($accessory, $accessory_users, $total)
    {
        $array = [];

        foreach ($accessory_users as $user) {
            $array[] = [

                'assigned_pivot_id' => $user->pivot->id,
                'id' => (int) $user->id,
                'username' => e($user->username),
                'name' => e($user->getFullNameAttribute()),
                'first_name' => e($user->first_name),
                'last_name' => e($user->last_name),
                'employee_number' =>  e($user->employee_num),
                'checkout_notes' => e($user->pivot->note),
                'last_checkout' => Helper::getFormattedDateObject($user->pivot->created_at, 'datetime'),
                'type' => 'user',
                'available_actions' => ['checkin' => true],
            ];
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }
}
