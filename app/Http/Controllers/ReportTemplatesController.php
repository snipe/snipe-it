<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use App\Models\ReportTemplate;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReportTemplatesController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('reports.view');

        $request->validate((new ReportTemplate)->getRules());

        $report = $request->user()->reportTemplates()->create([
            'name' => $request->get('name'),
            'options' => $request->except(['_token', 'name']),
        ]);

        session()->flash('success', trans('admin/reports/message.create.success'));

        return redirect()->route('report-templates.show', $report->id);
    }

    public function show($reportId)
    {
        $this->authorize('reports.view');

        $reportTemplate = ReportTemplate::find($reportId);

        if (!$reportTemplate) {
            return redirect()->route('reports/custom')
                ->with('error', trans('admin/reports/message.no_report_permission'));
        }

        $customfields = CustomField::get();
        $report_templates = ReportTemplate::orderBy('name')->get();

        return view('reports/custom', [
            'customfields' => $customfields,
            'report_templates' => $report_templates,
            'template' => $reportTemplate,
        ]);
    }

    public function edit($reportId): View
    {
        $this->authorize('reports.view');

        return view('reports/custom', [
            'customfields' => CustomField::get(),
            'template' => ReportTemplate::findOrFail($reportId),
        ]);
    }

    public function update(Request $request, $reportId): RedirectResponse
    {
        $this->authorize('reports.view');

        $reportTemplate = ReportTemplate::find($reportId);

        if (!$reportTemplate) {
            return redirect()->route('reports/custom')
                ->with('error', trans('admin/reports/message.no_report_permission'));
        }

        $reportTemplate->options = $request->except(['_token', 'name']);
        $reportTemplate->save();

        session()->flash('success', trans('admin/reports/message.update.success'));

        return redirect()->route('report-templates.show', $reportTemplate->id);
    }

    public function destroy($reportId): RedirectResponse
    {
        $this->authorize('reports.view');

        $reportTemplate = ReportTemplate::find($reportId);

        if (!$reportTemplate) {
            return redirect()->route('reports/custom')
                ->with('error', trans('admin/reports/message.delete.no_delete_permission'));
        }

        $reportTemplate->delete();

        return redirect()->route('reports/custom')
            ->with('success', trans('admin/reports/message.delete.success'));
    }
}
