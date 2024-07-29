<?php

namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Accessory;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class AccessoriesTransformer
{
    public function transformAccessories(Collection $accessories, $total)
    {
        $array = [];
        foreach ($accessories as $accessory) {
            $array[] = self::transformAccessory($accessory);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformAccessory(Accessory $accessory)
    {
        $array = [
            'id' => $accessory->id,
            'name' => e($accessory->name),
            'image' => ($accessory->image) ? Storage::disk('public')->url('accessories/'.e($accessory->image)) : null,
            'company' => ($accessory->company) ? ['id' => $accessory->company->id, 'name'=> e($accessory->company->name)] : null,
            'manufacturer' => ($accessory->manufacturer) ? ['id' => $accessory->manufacturer->id, 'name'=> e($accessory->manufacturer->name)] : null,
            'supplier' => ($accessory->supplier) ? ['id' => $accessory->supplier->id, 'name'=> e($accessory->supplier->name)] : null,
            'model_number' => ($accessory->model_number) ? e($accessory->model_number) : null,
            'category' => ($accessory->category) ? ['id' => $accessory->category->id, 'name'=> e($accessory->category->name)] : null,
            'location' => ($accessory->location) ? ['id' => $accessory->location->id, 'name'=> e($accessory->location->name)] : null,
            'notes' => ($accessory->notes) ? Helper::parseEscapedMarkedownInline($accessory->notes) : null,
            'qty' => ($accessory->qty) ? (int) $accessory->qty : null,
            'purchase_date' => ($accessory->purchase_date) ? Helper::getFormattedDateObject($accessory->purchase_date, 'date') : null,
            'purchase_cost' => Helper::formatCurrencyOutput($accessory->purchase_cost),
            'order_number' => ($accessory->order_number) ? e($accessory->order_number) : null,
            'min_qty' => ($accessory->min_amt) ? (int) $accessory->min_amt : null,
            'remaining_qty' => (int) $accessory->numRemaining(),
            'checkouts_count' =>  $accessory->checkouts_count,

            'created_at' => Helper::getFormattedDateObject($accessory->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($accessory->updated_at, 'datetime'),

        ];

        $permissions_array['available_actions'] = [
            'checkout' => Gate::allows('checkout', Accessory::class),
            'checkin' =>  false,
            'update' => Gate::allows('update', Accessory::class),
            'delete' => Gate::allows('delete', Accessory::class),
            'clone' => Gate::allows('create', Accessory::class),
            
        ];

        $permissions_array['user_can_checkout'] = false;

        if ($accessory->numRemaining() > 0) {
            $permissions_array['user_can_checkout'] = true;
        }

        $array += $permissions_array;

        return $array;
    }

    public function transformCheckedoutAccessory($accessory, $accessory_checkouts, $total)
    {
        $array = [];

        foreach ($accessory_checkouts as $checkout) {
            $array[] = [
                'id' => $checkout->id,
                'assigned_to' => $this->transformAssignedTo($checkout),
                'checkout_notes' => e($checkout->note),
                'last_checkout' => Helper::getFormattedDateObject($checkout->created_at, 'datetime'),
                'available_actions' => ['checkin' => true],
            ];
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformAssignedTo($accessoryCheckout)
    {
        if ($accessoryCheckout->checkedOutToUser()) {
            return [
                    'id' => (int) $accessoryCheckout->assigned->id,
                    'username' => e($accessoryCheckout->assigned->username),
                    'name' => e($accessoryCheckout->assigned->getFullNameAttribute()),
                    'first_name'=> e($accessoryCheckout->assigned->first_name),
                    'last_name'=> ($accessoryCheckout->assigned->last_name) ? e($accessoryCheckout->assigned->last_name) : null,
                    'email'=> ($accessoryCheckout->assigned->email) ? e($accessoryCheckout->assigned->email) : null,
                    'employee_number' =>  ($accessoryCheckout->assigned->employee_num) ? e($accessoryCheckout->assigned->employee_num) : null,
                    'type' => 'user',
                ];
        }

        return $accessoryCheckout->assigned ? [
            'id' => $accessoryCheckout->assigned->id,
            'name' => e($accessoryCheckout->assigned->display_name),
            'type' => $accessoryCheckout->assignedType(),
        ] : null;
    }
}
