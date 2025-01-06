<?php

namespace Tests\Unit\Models\ReportTemplates;

use App\Models\ReportTemplate;
use App\Models\User;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

#[Group('custom-reporting')]
#[Group('activity-logging')]
class ReportTemplateActivityLoggingTest extends TestCase
{
    public function testCreatingReportTemplateIsLogged()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $reportTemplate = ReportTemplate::factory()->create();

        $this->assertDatabaseHas('action_logs', [
            'created_by' => $user->id,
            'action_type' => 'create',
            'target_id' => null,
            'target_type' => null,
            'item_type' => ReportTemplate::class,
            'item_id' => $reportTemplate->id,
        ]);
    }

    public function testUpdatingReportTemplateIsLogged()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $reportTemplate = ReportTemplate::factory()->create([
            'name' => 'Name A',
            'options' => [
                'company' => '1',
                'location' => '1',
                'by_company_id' => ['1'],
                'by_location_id' => ['17'],
            ],
        ]);

        $reportTemplate->update([
            'name' => 'Another Name',
            'options' => [
                'company' => '1',
                'by_company_id' => ['1'],
            ],
        ]);

        $this->assertDatabaseHas('action_logs', [
            'created_by' => $user->id,
            'action_type' => 'update',
            'target_id' => null,
            'target_type' => null,
            'item_type' => ReportTemplate::class,
            'item_id' => $reportTemplate->id,
            'log_meta' => json_encode([
                'name' => [
                    'old' => 'Name A',
                    'new' => 'Another Name'
                ],
                'options' => [
                    'old' => [
                        'company' => '1',
                        'location' => '1',
                        'by_company_id' => ['1'],
                        'by_location_id' => ['17'],
                    ],
                    'new' => [
                        'company' => '1',
                        'by_company_id' => ['1'],
                    ],
                ],
            ]),
        ]);
    }

    public function testDeletingReportTemplateIsLogged()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $reportTemplate = ReportTemplate::factory()->create();

        $reportTemplate->delete();

        $this->assertDatabaseHas('action_logs', [
            'created_by' => $user->id,
            'action_type' => 'delete',
            'target_id' => null,
            'target_type' => null,
            'item_type' => ReportTemplate::class,
            'item_id' => $reportTemplate->id,
        ]);
    }
}
