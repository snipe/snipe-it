<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Asset;
use Gate;
use Illuminate\Database\Eloquent\Collection;

class DepreciationsReportTransformer
{

    public function transformDepreciations (Collection $depreciations)
    {

        $reportsArray = array();
        foreach ($depreciations as $depreciatedAsset)  {
            $reportsArray[] = self::transformDepreciationReport($depreciatedAsset);

        }
        return (new DatatablesTransformer)->transformDatatables(($reportsArray));
    }

    public function transformDepreciationReport ($depreciatedAsset)
    {
        $array = [
            'company_name'          => e($depreciatedAsset->company->name),
            'id'                    => (int) $depreciatedAsset->id,
            'model'                 => $depreciatedAsset->model->category->name,
            'deleted_at'            => $depreciatedAsset->deleted_at,
            'asset_tag'             => $depreciatedAsset->asset_tag,
            'asset_name'            => $depreciatedAsset->model->name,
            'serial'                => $depreciatedAsset->serial,
            'depreciation_type'     => $depreciatedAsset->model->depreciation->name,
            'depreciation_length'   => $depreciatedAsset->model->depreciation->months,
            'asset_status'          => $depreciatedAsset->assetstatus->name,
            'asset_checkedOut'      => $depreciatedAsset->checkedOutToUser(),
            'asset_assigned'        => $depreciatedAsset->assigned,
            'asset_fullNameAtt'     => $depreciatedAsset->assigned->getFullNameAttribute(),
            'asset_assigned_name'   => $depreciatedAsset->assigned->name,
            'location'              => $depreciatedAsset->location->name,
            'default_loc'           => $depreciatedAsset->defaultloc->name,
            'purchase_date'         => Carbon\Carbon::parse($depreciatedAsset->purchase_date)->format('Y-m-d'),
            'eol'                   => $depreciatedAsset->present()->eol_date(),
            'purchase_cost'         => $depreciatedAsset->purchase_cost,
            'location_currency'     => $depreciatedAsset->location->currency,

        ];
        return $array;
    }
}