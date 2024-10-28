<?php

namespace Tests\Feature\ReportTemplates;

use App\Models\ReportTemplate;
use App\Models\User;
use PHPUnit\Framework\Attributes\Group;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\TestCase;

#[Group('custom-reporting')]
class ShowReportTemplateTest extends TestCase implements TestsPermissionsRequirement
{
    public function testRequiresPermission()
    {
        $this->actingAs(User::factory()->create())
            ->get($this->getRoute(ReportTemplate::factory()->create()))
            ->assertForbidden();
    }

    public function testCanLoadASavedReportTemplate()
    {
        $user = User::factory()->canViewReports()->create();
        $reportTemplate = ReportTemplate::factory()->make(['name' => 'My Awesome Template']);
        $user->reportTemplates()->save($reportTemplate);

        $this->actingAs($user)
            ->get($this->getRoute($reportTemplate))
            ->assertOk()
            ->assertViewHas(['template' => function (ReportTemplate $templatePassedToView) use ($reportTemplate) {
                return $templatePassedToView->is($reportTemplate);
            }]);
    }

    public function testCannotLoadAnotherUsersSavedReportTemplate()
    {
        $reportTemplate = ReportTemplate::factory()->create();

        $this->actingAs(User::factory()->canViewReports()->create())
            ->get($this->getRoute($reportTemplate))
            ->assertSessionHas('error')
            ->assertRedirect(route('reports/custom'));
    }

    private function getRoute(ReportTemplate $reportTemplate): string
    {
        return route('report-templates.show', $reportTemplate);
    }
}
