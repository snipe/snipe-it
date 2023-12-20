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
//        This is for error handling in creation. This probably is the wrong spot, and syntax is off, but i don't wanna forget
//        if(is_null($report->name)) {
//            return redirect()->route('reports/custom')->with('error', trans('reports/message.create.needs_title'));
//        }
//        elseif(exists($report->name)) {
//            return redirect()->route('reports/custom')->with('error', trans('reports/message.create.duplicate'));
//        }

        return redirect()->route('report-templates.show', $report->id);
    }

    public function show(Request $request, $reportId)
    {
        $this->authorize('reports.view');

        $reportTemplate = ReportTemplate::find($reportId);

        if (!$reportTemplate) {
            return redirect()->route('reports/custom')
                ->with('error', 'Template does not exist or you do not have permission to view it.');
        }

        $customfields = CustomField::get();
        $report_templates = ReportTemplate::orderBy('name')->get();

        return view('reports/custom', [
            'customfields' => $customfields,
            'report_templates' => $report_templates,
            'reportTemplate' => $reportTemplate,
        ]);
    }

    public function edit(Request $request, $reportId)
    {
        $report = ReportTemplate::findOrFail($reportId);

        return view('reports/custom', [
            'customfields' => CustomField::get(),
            'reportTemplate' => $report,
        ]);
    }

    public function update(Request $request, $reportId)
    {
        $this->authorize('reports.view');

        $reportTemplate = ReportTemplate::find($reportId);

        if (!$reportTemplate) {
            // @todo: what is the behavior we want?
            return redirect()->route('reports/custom');
        }

        $reportTemplate->options = $request->except(['_token', 'name']);
        $reportTemplate->save();

        return redirect()->route('report-templates.show', $reportTemplate->id);
    }
}
