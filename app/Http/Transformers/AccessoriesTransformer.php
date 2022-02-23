<?php

namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Accessory;
use App\Models\Actionlog;
use Gate;
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
            'notes' => ($accessory->notes) ? e($accessory->notes) : null,
            'qty' => ($accessory->qty) ? (int) $accessory->qty : null,
            'purchase_date' => ($accessory->purchase_date) ? Helper::getFormattedDateObject($accessory->purchase_date, 'date') : null,
            'purchase_cost' => Helper::formatCurrencyOutput($accessory->purchase_cost),
            'order_number' => ($accessory->order_number) ? e($accessory->order_number) : null,
            'min_qty' => ($accessory->min_amt) ? (int) $accessory->min_amt : null,
            'remaining_qty' => $accessory->numRemaining(),

            'created_at' => Helper::getFormattedDateObject($accessory->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($accessory->updated_at, 'datetime'),

        ];

        $permissions_array['available_actions'] = [
            'checkout' => Gate::allows('checkout', Accessory::class),
            'checkin' =>  false,
            'update' => Gate::allows('update', Accessory::class),
            'delete' => Gate::allows('delete', Accessory::class),
        ];

        $permissions_array['user_can_checkout'] = false;

        if ($accessory->numRemaining() > 0) {
            $permissions_array['user_can_checkout'] = true;
        }

        $array += $permissions_array;

        return $array;
    }

    public function transformCheckedoutAccessory($accessory, $accessory_users, $accessory_sigs, $total)
    {
//        \Log::info($accessory_users); \Log::info($accessory);

        $array = [];
//       My problem is when this array is populated it doesn't stop to look at $accessory->accepted_signatures.
//       so I'm trying to get a for loop to check if the user->pivot->id matches $accessory_sigs->target_id (user id) to get the right signature.
//       Sounds good in theory. Can I be doing it better?? Im not sure....I just realized that accessory only pulls the lastcheckout. Going to work on a query first.
//       annoyed with this already..Something is broken and now the table won't populate. Ill give it another look tomorrow.
            foreach ($accessory_users as $user) {

                    $array[] = [

                        'assigned_pivot_id' => $user->pivot->id,
                        'id' => (int)$user->id,
                        'username' => e($user->username),
                        'name' => e($user->getFullNameAttribute()),
                        'first_name' => e($user->first_name),
                        'last_name' => e($user->last_name),
                        'employee_number' => e($user->employee_num),
                        'checkout_notes' => e($user->pivot->note),
                        'accept_signature' => $accessory->accepted_signature,
                        'last_checkout' => Helper::getFormattedDateObject($user->pivot->created_at, 'datetime'),
                        'type' => 'user',
                        'available_actions' => ['checkin' => true],
                    ];

            }


        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }
}
