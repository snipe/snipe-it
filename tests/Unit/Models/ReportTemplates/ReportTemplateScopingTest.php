<?php

namespace Tests\Unit\Models\ReportTemplates;

use App\Models\ReportTemplate;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

#[Group('custom-reporting')]
class ReportTemplateScopingTest extends TestCase
{
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
}
