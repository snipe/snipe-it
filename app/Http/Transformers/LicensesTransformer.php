<?php
namespace App\Http\Transformers;

use App\Models\License;
use Gate;
use Illuminate\Database\Eloquent\Collection;

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
            'id' => $license->id,
            'name' => e($license->name),
            'company' => e($license->company->name),
            'manufacturer' => ($license->manufacturer) ? $license->manufacturer : null,
            'serial' => e($license->name),
            'purchase_order' => e($license->order_number),
            'purchase_date' => e($license->purchase_date),
            'purchase_cost' => e($license->purchase_cost),
            'depreciation' => ($license->depreciation) ? $license->depreciation : null,
            'notes' => e($license->notes),
            'expiration_date' => e($license->expiration_date),
            'totalSeats' => e($license->seats),
            'remaining' => $license->remaincount(),
            'license_name' => e($license->license_name),
            'license_email' => e($license->license_email),
            'maintained' => ($license->maintained == 1) ? true : false,
            'supplier' => ($license->supplier) ? $license->supplier : null,
            'created_at' => $license->created_at,
        ];

        $permissions_array['available_actions'] = [
            'checkout' => Gate::allows('checkout', License::class) ? true : false,
            'checkin' => Gate::allows('checkin', License::class) ? true : false,
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
