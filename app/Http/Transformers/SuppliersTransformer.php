<?php
namespace App\Http\Transformers;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Collection;
use Gate;
use App\Helpers\Helper;

class SuppliersTransformer
{

    public function transformSuppliers (Collection $suppliers, $total)
    {
        $array = array();
        foreach ($suppliers as $supplier) {
            $array[] = self::transformSupplier($supplier);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformSupplier (Supplier $supplier = null)
    {
        if ($supplier) {



            $array = [
                'id' => e($supplier->id),
                'name' => e($supplier->name),
                'address' => ($supplier->address) ? e($supplier->address) : null,
                'address2' => ($supplier->address2) ? e($supplier->address2) : null,
                'city' => ($supplier->city) ? e($supplier->city) : null,
                'state' => ($supplier->state) ? e($supplier->state) : null,
                'country' =>($supplier->country) ? e($supplier->country) : null,
                'fax' =>($supplier->fax) ? e($supplier->fax) : null,
                'phone' => ($supplier->phone) ? e($supplier->phone) : null,
                'email' => ($supplier->email) ? e($supplier->email) : null,
                'contact' => ($supplier->contact) ? e($supplier->contact) : null,
                'assets_count' => $supplier->assets_count,
                'licenses_count' => $supplier->licenses_count,
                'created_at' => Helper::getFormattedDateObject($supplier->created_at, 'datetime'),
                'updated_at' => Helper::getFormattedDateObject($supplier->updated_at, 'datetime'),

            ];

            $permissions_array['available_actions'] = [
                'update' => Gate::allows('update', Supplier::class) ? true : false,
                'delete' => Gate::allows('delete', Supplier::class) ? true : false,
            ];

            $array += $permissions_array;

            return $array;
        }


    }



}
