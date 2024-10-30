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
        $reportTemplate = ReportTemplate::factory()->create();

        $user = User::factory()->create();
        $this->actingAs($user);
        $reportTemplateWithActingUser = ReportTemplate::factory()->create();

        $this->assertDatabaseHas('action_logs', [
            'created_by' => null,
            'action_type' => 'created',
            'target_id' => null,
            'target_type' => null,
            'item_type' => ReportTemplate::class,
            'item_id' => $reportTemplate->id,
        ]);

        $this->assertDatabaseHas('action_logs', [
            'created_by' => $user->id,
            'action_type' => 'created',
            'target_id' => null,
            'target_type' => null,
            'item_type' => ReportTemplate::class,
            'item_id' => $reportTemplateWithActingUser->id,
        ]);
    }

    public function testUpdatingReportTemplateIsLogged()
    {
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

        $user = User::factory()->create();
        $this->actingAs($user);
        $reportTemplateWithActingUser = ReportTemplate::factory()->create([
            'name' => 'Name B',
            'options' => [
                'company' => '1',
                'location' => '1',
                'by_company_id' => ['1'],
                'by_location_id' => ['17'],
            ],
        ]);
        $reportTemplateWithActingUser->update([
            'name' => 'Something Else',
            'options' => [
                'company' => '1',
                'by_company_id' => ['1'],
            ],
        ]);

        $this->assertDatabaseHas('action_logs', [
            'created_by' => null,
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

        $this->assertDatabaseHas('action_logs', [
            'created_by' => $user->id,
            'action_type' => 'update',
            'target_id' => null,
            'target_type' => null,
            'item_type' => ReportTemplate::class,
            'item_id' => $reportTemplateWithActingUser->id,
            'log_meta' => json_encode([
                'name' => [
                    'old' => 'Name B',
                    'new' => 'Something Else'
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
        $this->markTestIncomplete();
    }

    public function testLogsScopedProperly()
    {
        $this->markTestIncomplete();
    }
}
