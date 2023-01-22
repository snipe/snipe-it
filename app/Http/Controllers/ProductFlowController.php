<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Asset;
use App\Models\Company;
use App\Models\Statuslabel;
use App\Models\Accessory;
use App\Models\AssetModel;
use App\Helpers\Helper;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class ProductFlowController extends Controller
{
    public function index()
    {
        return view('productflow/receiving');
    }

    public function show(Request $request)
    {
        $accessory = Accessory::where('model_number', '=', $request->receiveParts)->get();

        $model = AssetModel::where('model_number', '=', $request->receiveParts)->get();     

        if($accessory->count() > 0) {
            $result = $accessory[0];
            return response()->json(Helper::formatStandardApiResponse('success', $result, "accessory"));
        }

        if ($model->count() > 0) {
            $result = $model[0];
            return response()->json(Helper::formatStandardApiResponse('success', $result, "asset"));
        }

        // Redirect if model is not found
        if ($request->receiveParts == "0") {
            return redirect()->route('productflow.receiving')->with('warning', "Model not found. Please click 'New' to add the model.")->with('model', $model);
        }
    }


    public function store(Request $request)
    {
        if ($request->input('serial_number')) {
            $this->authorize(Asset::class);
            $model_number = $request->input('model_number');

            $asset = new Asset();

            $asset->asset_tag               = $request->input('asset_tag');
            $asset->company_id              = Company::select('id')->where('name', '=', 'ETI')->get()[0]->id; // Hardcoded to ETI
            $asset->model_id                = AssetModel::select('id')->where('model_number', '=', $request->input('model_number'))->get()[0]->id;
            $asset->serial                  = $request->input('serial_number');
            $asset->user_id                 = Auth::id();
            $asset->archived                = '0';
            $asset->physical                = '1';
            $asset->depreciate              = '0';
            $asset->status_id               = Statuslabel::select('id')->where('name', '=', 'stock')->get()[0]->id;
            $asset->requestable             = 0;

            if ($asset->save()) {
                return redirect()->route('productflow.receiving')->with('success', "Successfully added $model_number to stock!");
            }
            return redirect()->back()->withInput()->withErrors($asset->getErrors());
        }

        // Need to finish the DB logic. Going to need to do a complete rework compared to the above code as this section needs to just update the accessory. This should have it's own public function actually....
       /*  if ($request->input('accessory_qty')) {
            $this->authorize(Accessory::class);
            $model_number = $request->input('model_number');

            $accessory = new Accessory();

            $accessory->asset_tag               = $request->input('asset_tag');
            $accessory->model_id                = AssetModel::select('id')->where('model_number', '=', $request->input('model_number'))->get()[0]->id;
            $accessory->user_id                 = Auth::id();
            $accessory->archived                = '0';
            $accessory->physical                = '1';
            $accessory->depreciate              = '0';
            $accessory->status_id               = Statuslabel::select('id')->where('name', '=', 'stock')->get()[0]->id;
            $accessory->requestable             = 0;

            if ($asset->save()) {
                return redirect()->route('productflow.receiving')->with('success', "Successfully added $model_number to stock!");
            }
            return redirect()->back()->withInput()->withErrors($accessory->getErrors());
        } */
    }
}
