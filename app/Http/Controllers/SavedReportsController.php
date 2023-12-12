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
}
