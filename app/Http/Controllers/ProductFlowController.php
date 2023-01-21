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
        $model = AssetModel::where('model_number', '=', $request->receiveParts)->get();
        /* 
        This will be added in later. Main focus is receiving Asset Models.
        The idea is to search and receive both accessories and Asset Models
        But there needs to more backend work done to make accessories function the way that I want

        TODO for Accessories:
            - Modify Accessories table to accept a UPC barcode number (most accessories don't have SN's)
            - Add functionality to increase on-hand accessory count.
            - Add functionality to 'consume' accessories and to decrease on-hand count when item is checked out (this may or may not live here).
                - There's already a lot of great functionality and framework built for checking things out so I'll probably just yoink that and modify how it behaves.
                - Main thing to address is to remove the requirement of it being checked out to a user. These are blind checkouts with no need to assign accessories to users.
        
        */
        // $accessory = Accessory::where('model_number', '=', $request->receiveParts)->get();

        /* if($accessory->count() > 0) {
            $result = $accessory;
            return $result;
        } */


        if ($model->count() > 0) {
            $result = $model[0];
            return response()->json(Helper::formatStandardApiResponse('success', $result, null));
        }

        // Redirect if model is not found
        if ($request->receiveParts == "0") {
            return redirect()->route('productflow.receiving')->with('warning', "Model not found. Please click 'New' to add the model.")->with('model', $model);
        }
    }


    public function store(Request $request)
    {
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
}
