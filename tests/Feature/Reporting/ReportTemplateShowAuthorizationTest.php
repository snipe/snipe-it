<?php

namespace Tests\Feature\Reporting;

use App\Models\ReportTemplate;
use App\Models\User;
use Tests\TestCase;

class ReportTemplateShowAuthorizationTest extends TestCase
{
    public function test_non_creator_cannot_see_private_template_via_model_scope(): void
    {
        $creator = User::factory()->create();
        $intruder = User::factory()->canViewReports()->create();

        $private = ReportTemplate::factory()->for($creator, 'creator')->notShared()->create();

        $this->actingAs($intruder);
        $this->assertNull(
            ReportTemplate::find($private->id),
            'Private template must not resolve via the global scope for a non-creator.',
        );
    }

    public function test_non_creator_gets_non_oracular_response_from_show_endpoint_for_private_template(): void
    {
        $creator = User::factory()->create();
        $intruder = User::factory()->canViewReports()->create();

        $private = ReportTemplate::factory()
            ->for($creator, 'creator')
            ->notShared()
            ->create(['name' => 'report-template-show-oracle-' . uniqid()]);

        $response = $this->actingAs($intruder)
            ->get(route('report-templates.show', $private->id));

        $response->assertRedirect(route('reports/custom'));
        $this->assertStringNotContainsString(
            $private->name,
            $response->getContent() ?: '',
            'Response body must not contain the private template name for a non-creator.',
        );
    }

    public function test_creator_can_still_read_their_own_private_template(): void
    {
        $creator = User::factory()->canViewReports()->create();
        $private = ReportTemplate::factory()->for($creator, 'creator')->notShared()->create();

        $this->actingAs($creator)
            ->get(route('report-templates.show', $private->id))
            ->assertOk();
    }

    public function test_shared_templates_remain_readable_by_any_reports_viewer(): void
    {
        $creator = User::factory()->create();
        $viewer = User::factory()->canViewReports()->create();

        $shared = ReportTemplate::factory()->for($creator, 'creator')->shared()->create();

        $this->actingAs($viewer)
            ->get(route('report-templates.show', $shared->id))
            ->assertOk();
    }
}
