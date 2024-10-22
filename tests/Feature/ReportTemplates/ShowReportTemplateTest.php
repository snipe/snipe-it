<?php

namespace Tests\Feature\ReportTemplates;

use App\Models\ReportTemplate;
use App\Models\User;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\TestCase;

class ShowReportTemplateTest extends TestCase implements TestsPermissionsRequirement
{
    public function testRequiresPermission()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('reports/custom'))
            ->assertForbidden();
    }

    public function testCanLoadCustomReportPage()
    {
        $this->actingAs(User::factory()->canViewReports()->create())
            ->get(route('reports/custom'))
            ->assertOk()
            ->assertViewHas(['template' => function (ReportTemplate $template) {
                // the view should have an empty report by default
                return $template->exists() === false;
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
            ->assertViewHas(['template' => function (ReportTemplate $templatePassedToView) use ($reportTemplate) {
                return $templatePassedToView->is($reportTemplate);
            }]);
    }
}
