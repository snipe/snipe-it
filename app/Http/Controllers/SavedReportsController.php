<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SavedReportsController extends Controller
{
    public function store(Request $request)
    {
        $report = $request->user()->savedReports()->create([
            'name' => $request->get('report_name'),
            'options' => $request->except(['_token', 'report_name']),
        ]);

        return redirect()->route('reports/custom', ['report' => $report->id]);
    }
}
