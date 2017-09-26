<?php
namespace App\Http\Transformers;

use App\Models\License;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\Helper;

class LicensesTransformer
{

    public function transformLicenses (Collection $licenses, $total)
    {
        $array = array();
        foreach ($licenses as $license) {
            $array[] = self::transformLicense($license);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformLicense (License $license)
    {
        $array = [
            'id' => (int) $license->id,
            'name' => e($license->name),
            'company' => ($license->company) ? ['id' => (int) $license->company->id,'name'=> e($license->company->name)] : null,
            'manufacturer' =>  ($license->manufacturer) ? ['id' => (int) $license->manufacturer->id,'name'=> e($license->manufacturer->name)] : null,
            'product_key' => e($license->serial),
            'order_number' => e($license->order_number),
            'purchase_order' => e($license->purchase_order),
            'purchase_date' => Helper::getFormattedDateObject($license->purchase_date, 'date'),
            'purchase_cost' => e($license->purchase_cost),
            'depreciation' => ($license->depreciation) ? ['id' => (int) $license->depreciation->id,'name'=> e($license->depreciation->name)] : null,
            'notes' => e($license->notes),
            'expiration_date' => Helper::getFormattedDateObject($license->expiration_date, 'date'),
            'total_seats' => (int) $license->seats,
            'next_seat' => ($license->freeSeat()) ?  (int) $license->freeSeat()->id : null,
            'remaining_qty' => (int) $license->remaincount(),
            'min_qty' => $license->remaincount(),
            'license_name' =>  e($license->license_name),
            'license_email' => e($license->license_email),
            'maintained' => ($license->maintained == 1) ? true : false,
            'supplier' =>  ($license->supplier) ? ['id' => (int)  $license->supplier->id,'name'=> e($license->supplier->name)] : null,
            'created_at' => Helper::getFormattedDateObject($license->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($license->updated_at, 'datetime'),
            'user_can_checkout' => (bool) ($license->remaincount() > 0),
        ];

        $permissions_array['available_actions'] = [
            'checkout' => Gate::allows('checkout', License::class) ? true : false,
            'checkin' => Gate::allows('checkin', License::class) ? true : false,
            'clone' => Gate::allows('create', License::class) ? true : false,
            'update' => Gate::allows('update', License::class) ? true : false,
            'delete' => Gate::allows('delete', License::class) ? true : false,
        ];

        $array += $permissions_array;

        return $array;
    }

    public function transformAssetsDatatable($licenses) {
        return (new DatatablesTransformer)->transformDatatables($licenses);
    }



}
