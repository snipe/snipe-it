<?php

namespace Tests\Feature\ReportTemplates;

use App\Models\ReportTemplate;
use App\Models\User;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\TestCase;

class UpdateReportTemplateTest extends TestCase implements TestsPermissionsRequirement
{
    public function testRequiresPermission()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('report-templates.update', 1))
            ->assertForbidden();
    }

    public function testCanLoadEditReportTemplatePage()
    {
        $user = User::factory()->canViewReports()->create();
        $reportTemplate = ReportTemplate::factory()->for($user)->create();

        $this->actingAs($user)
            ->get(route('report-templates.edit', $reportTemplate))
            ->assertOk();
    }

    public function testCanUpdateAReportTemplate()
    {
        $user = User::factory()->canViewReports()->create();

        $reportTemplate = ReportTemplate::factory()->for($user)->create([
            'options' => [
                'id' => 1,
                'category' => 1,
                'by_category_id' => 2,
                'company' => 1,
                'by_company_id' => [1, 2],
            ],
        ]);

        $this->actingAs($user)
            ->post(route('report-templates.update', $reportTemplate), [
                'id' => 1,
                'company' => 1,
                'by_company_id' => [3],
            ]);

        $reportTemplate->refresh();
        $this->assertEquals(1, $reportTemplate->checkmarkValue('id'));
        $this->assertEquals(0, $reportTemplate->checkmarkValue('category'));
        $this->assertEquals([], $reportTemplate->selectValues('by_category_id'));
        $this->assertEquals(1, $reportTemplate->checkmarkValue('company'));
        $this->assertEquals([3], $reportTemplate->selectValues('by_company_id'));
    }
}
