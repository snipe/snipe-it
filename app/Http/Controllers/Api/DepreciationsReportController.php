<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\DepreciationsReportTransformer;
use App\Models\Depreciation;
use Illuminate\Http\Request;

class DepreciationsReportController extends Controller
{
    /**
     * Display a listing of all assets in the selected depreciation fields.
     *
     * @author  [G. Martinez] [<gmartinez@grokability.com>]
     * @since [v5.16]
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Asset::class);

        $assets = Asset::select([
            'assets.company_id',
            'assets.id',
            'assets.model_id',
            'assets.deleted_at',
            'assets.asset_tag',
            'assets.name',
            'assets.serial',
            'assets.status_id',
            'assets.assigned_to',
            'assets.location_id',
            'assets.purchase_date',
            'assets.purchase_cost',
        ]);


    }

}
