<?php

namespace Tests\Feature\ReportTemplates;

use App\Models\ReportTemplate;
use App\Models\User;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\TestCase;

class EditReportTemplateTest extends TestCase implements TestsPermissionsRequirement
{
    public function testRequiresPermission()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('report-templates.edit', ReportTemplate::factory()->create()))
            ->assertForbidden();
    }

    public function testCannotLoadEditPageForAnotherUsersReportTemplate()
    {
        $this->markTestIncomplete('Returns 404...');

        $user = User::factory()->canViewReports()->create();
        $reportTemplate = ReportTemplate::factory()->create();

        $this->actingAs($user)
            ->get(route('report-templates.edit', $reportTemplate))
            ->assertSessionHas('error')
            ->assertRedirect(route('reports/custom'));
    }

    public function testCanLoadEditReportTemplatePage()
    {
        $user = User::factory()->canViewReports()->create();
        $reportTemplate = ReportTemplate::factory()->for($user, 'creator')->create();

        $this->actingAs($user)
            ->get(route('report-templates.edit', $reportTemplate))
            ->assertOk();
    }
}
