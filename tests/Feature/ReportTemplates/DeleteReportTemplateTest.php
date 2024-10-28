<?php

namespace Tests\Feature\ReportTemplates;

use App\Models\ReportTemplate;
use App\Models\User;
use PHPUnit\Framework\Attributes\Group;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\TestCase;

#[Group('custom-reporting')]
class DeleteReportTemplateTest extends TestCase implements TestsPermissionsRequirement
{
    public function testRequiresPermission()
    {
        $reportTemplate = ReportTemplate::factory()->create();

        $this->actingAs(User::factory()->create())
            ->post($this->getRoute($reportTemplate))
            ->assertForbidden();

        $this->assertModelExists($reportTemplate);
    }

    public function testCannotDeleteAnotherUsersReportTemplate()
    {
        $reportTemplate = ReportTemplate::factory()->create();

        $this->actingAs(User::factory()->canViewReports()->create())
            ->delete($this->getRoute($reportTemplate))
            ->assertSessionHas('error')
            ->assertRedirect(route('reports/custom'));

        $this->assertModelExists($reportTemplate);
    }

    public function testCanDeleteAReportTemplate()
    {
        $user = User::factory()->canViewReports()->create();
        $reportTemplate = ReportTemplate::factory()->for($user, 'creator')->create();

        $this->actingAs($user)
            ->delete($this->getRoute($reportTemplate))
            ->assertRedirect(route('reports/custom'));

        $this->assertModelMissing($reportTemplate);
    }

    private function getRoute(ReportTemplate $reportTemplate): string
    {
        return route('report-templates.destroy', $reportTemplate->id);
    }
}
