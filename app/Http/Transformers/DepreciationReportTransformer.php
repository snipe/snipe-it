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
        foreach ($depreciations as $asset)  {
            $reportsArray[] = self::transformDepreciationReport($asset);

        }
        return (new DatatablesTransformer)->transformDatatables(($reportsArray));
    }

    public function transformDepreciationReport ($asset)
    {
        $array = [
            'company_name'          => e($asset->company->name),
            'id'                    => (int) $asset->id,
            'model'                 => $asset->model->category->name,
            'deleted_at'            => $asset->deleted_at,
            'asset_tag'             => $asset->asset_tag,
            'asset_name'            => $asset->model->name,
            'serial'                => $asset->serial,
            'depreciation_type'     => $asset->model->depreciation->name,
            'depreciation_length'   => $asset->model->depreciation->months,
            'asset_status'          => $asset->assetstatus->name,
            'asset_checkedOut'      => $asset->checkedOutToUser(),
            'asset_assigned'        => $asset->assigned,
            'asset_fullNameAtt'     => $asset->assigned->getFullNameAttribute(),
            'asset_assigned_name'   => $asset->assigned->name,
            'location'              => $asset->location->name,
            'default_loc'           => $asset->defaultloc->name,
            'purchase_date'         => Carbon\Carbon::parse($asset->purchase_date)->format('Y-m-d'),
            'eol'                   => $asset->present()->eol_date(),
            'purchase_cost'         => $asset->purchase_cost,
            'location_currency'     => $asset->location->currency,
            'current_value'         => $asset->getDepreciatedValue(),

        ];
        return $array;
    }
}