<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use App\Models\ReportTemplate;
use Illuminate\Http\Request;

class ReportTemplatesController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('reports.view');

        $request->validate((new ReportTemplate)->getRules());

        $report = $request->user()->reportTemplates()->create([
            'name' => $request->get('name'),
            'options' => $request->except(['_token', 'name']),
        ]);

        return redirect()->route('report-templates.show', $report->id);
    }

    public function show($reportId)
    {
        $this->authorize('reports.view');

        $reportTemplate = ReportTemplate::find($reportId);

        if (!$reportTemplate) {
            return redirect()->route('reports/custom')
                ->with('error', 'Template does not exist or you do not have permission to view it.'); //needs translation
        }

        $customfields = CustomField::get();
        $report_templates = ReportTemplate::orderBy('name')->get();

        return view('reports/custom', [
            'customfields' => $customfields,
            'report_templates' => $report_templates,
            'reportTemplate' => $reportTemplate,
        ]);
    }

    public function edit($reportId)
    {
        return view('reports/custom', [
            'customfields' => CustomField::get(),
            'reportTemplate' => ReportTemplate::findOrFail($reportId),
        ]);
    }

    public function update(Request $request, $reportId)
    {
        $this->authorize('reports.view');

        $reportTemplate = ReportTemplate::find($reportId);

        if (!$reportTemplate) {
            return redirect()->route('reports/custom')
                ->with('error', 'Template does not exist or you do not have permission to view it.');
        }

        $reportTemplate->options = $request->except(['_token', 'name']);
        $reportTemplate->save();

        return redirect()->route('report-templates.show', $reportTemplate->id);
    }

    public function destroy($reportId)
    {
        $this->authorize('reports.view');

        $reportTemplate = ReportTemplate::find($reportId);

        if (!$reportTemplate) {
            return redirect()->route('reports/custom')
                ->with('error', 'Template does not exist or you do not have permission to delete it.');
        }

        $reportTemplate->delete();

        return redirect()->route('reports/custom')
            ->with('success', 'Template deleted.');
    }
}
