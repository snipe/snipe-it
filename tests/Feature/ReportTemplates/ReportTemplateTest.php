<?php

namespace Tests\Feature\ReportTemplates;

use App\Models\ReportTemplate;
use App\Models\User;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class ReportTemplateTest extends TestCase
{
    use InteractsWithSettings;

    public function testCanLoadCustomReportPage()
    {
        $this->actingAs(User::factory()->canViewReports()->create())
            ->get(route('reports/custom'))
            ->assertOk()
            ->assertViewHas(['reportTemplate' => function (ReportTemplate $report) {
                // the view should have an empty report by default
                return $report->exists() === false;
            }]);
    }

    public function testCanLoadASavedReportTemplate()
    {
        $user = User::factory()->canViewReports()->create();
        $reportTemplate = ReportTemplate::factory()->make(['name' => 'My Awesome Template']);
        $user->reportTemplates()->save($reportTemplate);

        $this->actingAs($user)
            ->get(route('report-templates.show', $reportTemplate))
            ->assertOk()
            ->assertViewHas(['reportTemplate' => function (ReportTemplate $viewReport) use ($reportTemplate) {
                return $viewReport->is($reportTemplate);
            }]);
    }

    public function testCanSaveAReportTemplate()
    {
        $user = User::factory()->canViewReports()->create();

        $this->actingAs($user)
            ->post(route('report-templates.store'), [
                'name' => 'My Awesome Template',
                'company' => '1',
                'by_company_id' => ['1', '2'],
            ])
            ->assertRedirect();

        $template = $user->reportTemplates->first(function ($report) {
            return $report->name === 'My Awesome Template';
        });

        $this->assertNotNull($template);
        $this->assertEquals('1', $template->options['company']);
        $this->assertEquals(['1', '2'], $template->options['by_company_id']);
    }

    public function testReportTemplateRequiresValidFields()
    {
        $this->actingAs(User::factory()->canViewReports()->create())
            ->post(route('report-templates.store'), [
                //
            ])
            ->assertSessionHasErrors('name');
    }

    public function testSavingReportTemplateRequiresCorrectPermission()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('report-templates.store'))
            ->assertForbidden();
    }
}
