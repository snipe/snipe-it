<?php

namespace App\Http\Controllers;

use App\Models\SavedReport;
use Illuminate\Http\Request;

class SavedReportsController extends Controller
{
    public function store(Request $request)
    {
        $savedReport = SavedReport::first();

        $savedReport->options = $request->except('_token');

        $savedReport->save();

        // @todo: should this redirect elsewhere?
        return redirect()->back();
    }
}
