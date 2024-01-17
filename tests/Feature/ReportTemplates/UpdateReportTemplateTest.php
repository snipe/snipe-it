<?php

namespace Feature\ReportTemplates;

use App\Models\ReportTemplate;
use App\Models\User;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class UpdateReportTemplateTest extends TestCase
{
    use InteractsWithSettings;

    public function testUpdatingReportTemplateRequiresCorrectPermission()
    {
        $this->markTestIncomplete();
    }

    public function testUpdatingReportTemplateRequiresValidFields()
    {
        $this->markTestIncomplete();
    }

    public function testCanUpdateAReportTemplate()
    {
        $this->markTestIncomplete();

        $user = User::factory()->canViewReports()->create();

        $reportTemplate = ReportTemplate::factory()->for($user)->create();

        $this->actingAs($user)
            ->get(route('report-templates.edit', $reportTemplate))
            ->assertOk();

        // @todo:
    }
}
