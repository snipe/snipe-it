<?php

namespace App\Http\Controllers;

use App\Models\SavedReport;
use Illuminate\Http\Request;

class SavedReportsController extends Controller
{
    public function store(Request $request)
    {
        // @todo: make this dynamic
        $savedReport = SavedReport::first();

        $savedReport->options = $request->except('_token');

        $savedReport->save();

        // @todo: redirect back with the saved report pre-populated?
        return redirect()->back();
    }
}
