<?php
namespace App\Http\Transformers;

use App\Models\LicenseModel;
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

    public function transformLicense (LicenseModel $licenseModel)
    {
        $array = [
            'id' => (int) $licenseModel->id,
            'name' => e($licenseModel->name),
            'company' => ($licenseModel->company) ? ['id' => (int) $licenseModel->company->id,'name'=> e($licenseModel->company->name)] : null,
            'manufacturer' =>  ($licenseModel->manufacturer) ? ['id' => (int) $licenseModel->manufacturer->id,'name'=> e($licenseModel->manufacturer->name)] : null,
            'product_key' => (Gate::allows('viewKeys', LicenseModel::class)) ? e($licenseModel->serial) : '------------',
            'order_number' => e($licenseModel->order_number),
            'purchase_order' => e($licenseModel->purchase_order),
            'purchase_date' => Helper::getFormattedDateObject($licenseModel->purchase_date, 'date'),
            'purchase_cost' => e($licenseModel->purchase_cost),
            'notes' => e($licenseModel->notes),
            'expiration_date' => Helper::getFormattedDateObject($licenseModel->expiration_date, 'date'),
            'seats' => (int) $licenseModel->licenses->count(),
            'free_seats_count' => (int) $licenseModel->freeLicenses->count(),
            'license_name' =>  e($licenseModel->license_name),
            'license_email' => e($licenseModel->license_email),
            'maintained' => ($licenseModel->maintained == 1) ? true : false,
            'supplier' =>  ($licenseModel->supplier) ? ['id' => (int)  $licenseModel->supplier->id,'name'=> e($licenseModel->supplier->name)] : null,
            'category' =>  ($licenseModel->category) ? ['id' => (int)  $licenseModel->category->id,'name'=> e($licenseModel->category->name)] : null,
            'created_at' => Helper::getFormattedDateObject($licenseModel->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($licenseModel->updated_at, 'datetime'),
            'user_can_checkout' => (bool) ($licenseModel->freeLicenses->count() > 0),
        ];

        $permissions_array['available_actions'] = [
            'checkout' => Gate::allows('checkout', LicenseModel::class) ? true : false,
            'checkin' => Gate::allows('checkin', LicenseModel::class) ? true : false,
            'clone' => Gate::allows('create', LicenseModel::class) ? true : false,
            'update' => Gate::allows('update', LicenseModel::class) ? true : false,
            'delete' => Gate::allows('delete', LicenseModel::class) ? true : false,
        ];

        $array += $permissions_array;

        return $array;
    }

    public function transformAssetsDatatable($licenses) {
        return (new DatatablesTransformer)->transformDatatables($licenses);
    }



}
