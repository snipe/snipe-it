<?php

namespace Tests\Feature\ReportTemplates;

use App\Models\ReportTemplate;
use App\Models\User;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class UpdateReportTemplateTest extends TestCase
{
    use InteractsWithSettings;

    public function testUpdatingReportTemplateRequiresCorrectPermission()
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

    public function testUpdatingReportTemplateRequiresValidFields()
    {
        $this->markTestIncomplete();

        $this->actingAs(User::factory()->canViewReports()->create())
            ->post(route('report-templates.update', ReportTemplate::factory()->create()))
            // @todo: name isn't being passed in this case
            ->assertSessionHasErrors('name');
    }

    public function testCanUpdateAReportTemplate()
    {
        $this->markTestIncomplete();

        $user = User::factory()->canViewReports()->create();

        $reportTemplate = ReportTemplate::factory()->for($user)->create([
            'options' => [
                'id' => 1,
                'company' => 1,
                'by_company_id' => [1, 2],
            ],
        ]);

        $this->actingAs($user)
            ->post(route('report-templates.update', $reportTemplate), [
                'id' => 1,
                'by_company_id' => [3],
            ])
            ->assertOk();

        // @todo:
        $reportTemplate->fresh();
        dd($reportTemplate->options);
    }
}
