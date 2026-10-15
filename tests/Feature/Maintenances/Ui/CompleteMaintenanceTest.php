<?php

namespace Tests\Feature\Maintenances\Ui;

use App\Models\Actionlog;
use App\Models\Maintenance;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;

class CompleteMaintenanceTest extends TestCase
{
    public function test_requires_permission()
    {
        $maintenance = Maintenance::factory()->create();

        $this->actingAs(User::factory()->create())
            ->post(route('maintenances.complete', $maintenance))
            ->assertForbidden();

        $this->assertDatabaseMissing('maintenances', [
            'id' => $maintenance->id,
            'completed_at' => now(),
        ]);
    }

    public function test_can_mark_maintenance_complete()
    {
        $actor = User::factory()->superuser()->create();
        $maintenance = Maintenance::factory()->create();

        $this->actingAs($actor)
            ->post(route('maintenances.complete', $maintenance))
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $maintenance->refresh();
        $this->assertNotNull($maintenance->completed_at);
        $this->assertEquals($actor->id, $maintenance->completed_by);

        $this->assertHasTheseActionLogs($maintenance, ['create', 'completed']);
    }

    public function test_marking_complete_does_not_create_update_log()
    {
        $actor = User::factory()->superuser()->create();
        $maintenance = Maintenance::factory()->create();

        $this->actingAs($actor)
            ->post(route('maintenances.complete', $maintenance));

        $updateLogs = Actionlog::where('item_type', Maintenance::class)
            ->where('item_id', $maintenance->id)
            ->where('action_type', 'update')
            ->count();

        $this->assertEquals(0, $updateLogs);
    }

    public function test_cannot_mark_already_completed_maintenance_complete()
    {
        $actor = User::factory()->superuser()->create();
        $maintenance = Maintenance::factory()->create(['completed_at' => now()->subDay(), 'completed_by' => $actor->id]);

        $this->actingAs($actor)
            ->post(route('maintenances.complete', $maintenance))
            ->assertRedirect()
            ->assertSessionHas('warning');

        $this->assertHasTheseActionLogs($maintenance, ['create']);
    }

    public function test_completion_note_is_saved_in_actionlog()
    {
        $actor = User::factory()->superuser()->create();
        $maintenance = Maintenance::factory()->create();

        $this->actingAs($actor)
            ->post(route('maintenances.complete', $maintenance), ['note' => 'Widget replaced']);

        $log = Actionlog::where('item_type', Maintenance::class)
            ->where('item_id', $maintenance->id)
            ->where('action_type', 'completed')
            ->first();

        $this->assertNotNull($log);
        $this->assertEquals('Widget replaced', $log->note);
    }

    public function test_duration_is_calculated_from_created_at()
    {
        $actor = User::factory()->superuser()->create();

        Carbon::setTestNow(Carbon::create(2026, 1, 1));
        $maintenance = Maintenance::factory()->create(['start_date' => '2025-06-01']);
        Carbon::setTestNow(Carbon::create(2026, 1, 11));

        try {
            $this->actingAs($actor)
                ->post(route('maintenances.complete', $maintenance))
                ->assertRedirect();

            $maintenance->refresh();
            $this->assertEquals(10, $maintenance->asset_maintenance_time);
        } finally {
            Carbon::setTestNow();
        }
    }
}
