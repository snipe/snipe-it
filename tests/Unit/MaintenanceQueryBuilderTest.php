<?php

namespace Tests\Unit;

use App\Models\Maintenance;
use App\Models\Setting;
use Tests\TestCase;

class MaintenanceQueryBuilderTest extends TestCase
{
    public function test_active_scope_excludes_completed_maintenances()
    {
        $active = Maintenance::factory()->create(['completed_at' => null]);
        $done = Maintenance::factory()->create(['completed_at' => now()]);

        $ids = Maintenance::active()->pluck('id');

        $this->assertContains($active->id, $ids);
        $this->assertNotContains($done->id, $ids);
    }

    public function test_completed_scope_excludes_active_maintenances()
    {
        $active = Maintenance::factory()->create(['completed_at' => null]);
        $done = Maintenance::factory()->create(['completed_at' => now()]);

        $ids = Maintenance::completed()->pluck('id');

        $this->assertNotContains($active->id, $ids);
        $this->assertContains($done->id, $ids);
    }

    public function test_due_for_completion_returns_items_in_warning_window()
    {
        $settings = Setting::factory()->create(['audit_warning_days' => 7]);

        $due = Maintenance::factory()->create([
            'completion_date' => now()->addDays(3)->format('Y-m-d'),
            'completed_at' => null,
        ]);

        $notDueYet = Maintenance::factory()->create([
            'completion_date' => now()->addDays(30)->format('Y-m-d'),
            'completed_at' => null,
        ]);

        $alreadyDone = Maintenance::factory()->create([
            'completion_date' => now()->addDays(3)->format('Y-m-d'),
            'completed_at' => now(),
        ]);

        $ids = Maintenance::dueForCompletion($settings)->pluck('id');

        $this->assertContains($due->id, $ids);
        $this->assertNotContains($notDueYet->id, $ids);
        $this->assertNotContains($alreadyDone->id, $ids);
    }

    public function test_overdue_for_completion_returns_past_due_items()
    {
        $overdue = Maintenance::factory()->create([
            'completion_date' => now()->subDay()->format('Y-m-d'),
            'completed_at' => null,
        ]);

        $futureDate = Maintenance::factory()->create([
            'completion_date' => now()->addDays(5)->format('Y-m-d'),
            'completed_at' => null,
        ]);

        $alreadyDone = Maintenance::factory()->create([
            'completion_date' => now()->subDay()->format('Y-m-d'),
            'completed_at' => now(),
        ]);

        $ids = Maintenance::overdueForCompletion()->pluck('id');

        $this->assertContains($overdue->id, $ids);
        $this->assertNotContains($futureDate->id, $ids);
        $this->assertNotContains($alreadyDone->id, $ids);
    }

    public function test_overdue_for_completion_excludes_items_with_no_completion_date()
    {
        $noDate = Maintenance::factory()->create([
            'completion_date' => null,
            'completed_at' => null,
        ]);

        $ids = Maintenance::overdueForCompletion()->pluck('id');

        $this->assertNotContains($noDate->id, $ids);
    }

    public function test_due_or_overdue_returns_both_overdue_and_due()
    {
        $settings = Setting::factory()->create(['audit_warning_days' => 7]);

        $overdue = Maintenance::factory()->create([
            'completion_date' => now()->subDay()->format('Y-m-d'),
            'completed_at' => null,
        ]);

        $due = Maintenance::factory()->create([
            'completion_date' => now()->addDays(3)->format('Y-m-d'),
            'completed_at' => null,
        ]);

        $fine = Maintenance::factory()->create([
            'completion_date' => now()->addDays(30)->format('Y-m-d'),
            'completed_at' => null,
        ]);

        $done = Maintenance::factory()->create([
            'completion_date' => now()->subDay()->format('Y-m-d'),
            'completed_at' => now(),
        ]);

        $ids = Maintenance::dueOrOverdueForCompletion($settings)->pluck('id');

        $this->assertContains($overdue->id, $ids);
        $this->assertContains($due->id, $ids);
        $this->assertNotContains($fine->id, $ids);
        $this->assertNotContains($done->id, $ids);
    }
}
