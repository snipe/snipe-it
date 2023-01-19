<?php

namespace App\Http\Controllers;

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
        return redirect()->route('productflow.receiving')->with('success', "Successfully added $request->model_number to stock!");
        // return response()->json(Helper::formatStandardApiResponse('success', $request->model_number, 'testing'));
    }

    
}
