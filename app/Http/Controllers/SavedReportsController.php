<?php

namespace App\Http\Controllers;

use App\Models\SavedReport;
use Illuminate\Http\Request;

class SavedReportsController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('reports.view');

        $request->validate((new SavedReport)->getRules());

        $report = $request->user()->savedReports()->create([
            'name' => $request->get('name'),
            'options' => $request->except(['_token', 'name']),
        ]);

        return redirect()->route('reports/custom', ['report' => $report->id]);
    }

    public function update(Request $request)
    {
        $this->authorize('update',SavedReport::class);

        if(is_null($reportid = SavedReport::find($request)))
        {
            return redirect()->route('reports/custom');
        }

        $request->validate()->report->id->getRules();


        $report = $request->user()->savedReports()->edit([
            'name' => $request->get('name'),
            'options' => $request->except(['token','name']),
        ]);

        return redirect()->route('reports/custom', ['report' => $report->id]);

    }
}
