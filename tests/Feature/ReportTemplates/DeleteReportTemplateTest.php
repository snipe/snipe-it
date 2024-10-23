<?php

namespace Tests\Feature\ReportTemplates;

use App\Models\ReportTemplate;
use App\Models\User;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\TestCase;

class DeleteReportTemplateTest extends TestCase implements TestsPermissionsRequirement
{
    public function testRequiresPermission()
    {
        $reportTemplate = ReportTemplate::factory()->create();

        $this->actingAs(User::factory()->create())
            ->post(route('report-templates.destroy', $reportTemplate->id))
            ->assertForbidden();

        $this->assertModelExists($reportTemplate);
    }

    public function testCannotDeleteAnotherUsersReportTemplate()
    {
        $reportTemplate = ReportTemplate::factory()->create();

        $this->actingAs(User::factory()->canViewReports()->create())
            ->delete(route('report-templates.destroy', $reportTemplate))
            ->assertSessionHas('error')
            ->assertRedirect(route('reports/custom'));

        $this->assertModelExists($reportTemplate);
    }

    public function testCanDeleteAReportTemplate()
    {
        $user = User::factory()->canViewReports()->create();
        $reportTemplate = ReportTemplate::factory()->for($user)->create();

        $this->actingAs($user)
            ->delete(route('report-templates.destroy', $reportTemplate))
            ->assertRedirect(route('reports/custom'));

        $this->assertModelMissing($reportTemplate);
    }
}
