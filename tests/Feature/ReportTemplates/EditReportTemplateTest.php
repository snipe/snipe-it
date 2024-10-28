<?php

namespace Tests\Feature\ReportTemplates;

use App\Models\ReportTemplate;
use App\Models\User;
use PHPUnit\Framework\Attributes\Group;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\TestCase;

#[Group('custom-reporting')]
class EditReportTemplateTest extends TestCase implements TestsPermissionsRequirement
{
    public function testRequiresPermission()
    {
        $this->actingAs(User::factory()->create())
            ->get($this->getRoute(ReportTemplate::factory()->create()))
            ->assertForbidden();
    }

    public function testCannotLoadEditPageForAnotherUsersReportTemplate()
    {
        $user = User::factory()->canViewReports()->create();
        $reportTemplate = ReportTemplate::factory()->create();

        $this->actingAs($user)
            ->get($this->getRoute($reportTemplate))
            ->assertSessionHas('error')
            ->assertRedirect(route('reports/custom'));
    }

    public function testCanLoadEditReportTemplatePage()
    {
        $user = User::factory()->canViewReports()->create();
        $reportTemplate = ReportTemplate::factory()->for($user, 'creator')->create();

        $this->actingAs($user)
            ->get($this->getRoute($reportTemplate))
            ->assertOk();
    }

    private function getRoute(ReportTemplate $reportTemplate): string
    {
        return route('report-templates.edit', $reportTemplate);
    }
}
