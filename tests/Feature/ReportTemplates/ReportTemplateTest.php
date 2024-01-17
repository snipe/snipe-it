<?php

namespace Tests\Feature\ReportTemplates;

use App\Models\ReportTemplate;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
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
            ->assertViewHas(['template' => function (ReportTemplate $template) {
                // the view should have an empty report by default
                return $template->exists() === false;
            }]);
    }

    public function testSavedTemplatesAreScopedToTheUser()
    {
        // Given there is a saved template for one user
        ReportTemplate::factory()->create(['name' => 'Report A']);

        // When loading reports/custom while acting as another user that also has a saved template
        $user = User::factory()->canViewReports()
            ->has(ReportTemplate::factory(['name' => 'Report B']))
            ->create();

        // The user should not see the other user's template (in view as 'report_templates')
        $this->actingAs($user)
            ->get(route('reports/custom'))
            ->assertViewHas(['report_templates' => function (Collection $reports) {
                return $reports->pluck('name')->doesntContain('Report A');
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

    public function testSavingReportTemplateRequiresValidFields()
    {
        $this->actingAs(User::factory()->canViewReports()->create())
            ->post(route('report-templates.store'), [
                'name' => '',
            ])
            ->assertSessionHasErrors('name');
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

    public function testRedirectingAfterValidationErrorRestoresInputs()
    {
        $this->actingAs(User::factory()->canViewReports()->create())
            // start on the custom report page
            ->from(route('reports/custom'))
            ->followingRedirects()
            ->post(route('report-templates.store'), [
                'name' => '',
                // set some values to ensure they are still present
                // when returning to the custom report page.
                'by_company_id' => [2, 3]
            ])->assertViewHas(['template' => function (ReportTemplate $reportTemplate) {
                return data_get($reportTemplate, 'options.by_company_id') === [2, 3];
            }]);
    }

    public function testUpdatingReportTemplateRequiresValidFields()
    {
        $this->markTestIncomplete();
    }

    public function testSavingReportTemplateRequiresCorrectPermission()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('report-templates.store'))
            ->assertForbidden();
    }

    public function testUpdatingReportTemplateRequiresCorrectPermission()
    {
        $this->markTestIncomplete();
    }

    public function testCanDeleteAReportTemplate()
    {
        $this->markTestIncomplete();
    }

    public function testDeletingReportTemplateRequiresCorrectPermission()
    {
        $this->markTestIncomplete();
    }
}
