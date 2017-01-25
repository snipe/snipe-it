<?php
namespace App\Http\Transformers;

use App\Models\License;
use App\Models\LicenseSeat;
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
            'name' => $license->name,
            'companyName' => $license->companyName,
            'manufacturer' => ($license->manufacturer) ? $license->manufacturer : null,
            'serial' => $license->name,
            'purchase_order' => $license->order_number,
            'purchase_date' => $license->purchase_date,
            'purchase_cost' => $license->purchase_cost,
            'depreciation' => ($license->depreciation) ? $license->depreciation : null,
            'notes' => $license->notes,
            'expiration_date' => $license->expiration_date,
            'totalSeats' => $license->seats,
            'remaining' => $license->remaincount(),
            'license_name' => $license->license_name,
            'license_email' => $license->license_email,
            'maintained' => ($license->maintained==1) ? true : false,
            'supplier' => ($license->supplier) ? $license->supplier : null,
            'created_at' => $license->created_at,


        ];

        return $array;
    }

    public function transformAssetsDatatable($licenses) {
        return (new DatatablesTransformer)->transformDatatables($licenses);
    }



}
