<?php

namespace Tests\Feature\Maintenances\Api;

use App\Models\Actionlog;
use App\Models\Maintenance;
use App\Models\User;
use Tests\TestCase;

class MaintenanceNotesTest extends TestCase
{
    public function test_index_requires_permission()
    {
        $maintenance = Maintenance::factory()->create();

        $this->actingAsForApi(User::factory()->create())
            ->getJson(route('api.maintenances.notes.index', $maintenance))
            ->assertForbidden();
    }

    public function test_index_returns_notes_for_maintenance()
    {
        $actor = User::factory()->superuser()->create();
        $maintenance = Maintenance::factory()->create();

        $log = new Actionlog;
        $log->item_type = Maintenance::class;
        $log->item_id = $maintenance->id;
        $log->note = 'Test note content';
        $log->created_by = $actor->id;
        $log->logaction('note added');

        $response = $this->actingAsForApi($actor)
            ->getJson(route('api.maintenances.notes.index', $maintenance))
            ->assertOk()
            ->assertStatusMessageIs('success');

        $notes = $response->json('payload.notes');
        $this->assertCount(1, $notes);
        $this->assertEquals('Test note content', $notes[0]['note']);
    }

    public function test_index_does_not_return_other_action_types()
    {
        $actor = User::factory()->superuser()->create();
        $maintenance = Maintenance::factory()->create();

        $this->actingAsForApi($actor)
            ->getJson(route('api.maintenances.notes.index', $maintenance))
            ->assertOk();

        // The create actionlog from factory should not appear (it's 'create' not 'note added')
        $response = $this->actingAsForApi($actor)
            ->getJson(route('api.maintenances.notes.index', $maintenance))
            ->assertOk();

        $notes = $response->json('payload.notes');
        $this->assertEmpty($notes);
    }

    public function test_store_requires_permission()
    {
        $maintenance = Maintenance::factory()->create();

        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.maintenances.notes.store', $maintenance), ['note' => 'Test'])
            ->assertForbidden();
    }

    public function test_store_validates_note_is_required()
    {
        $actor = User::factory()->superuser()->create();
        $maintenance = Maintenance::factory()->create();

        $this->actingAsForApi($actor)
            ->postJson(route('api.maintenances.notes.store', $maintenance), ['note' => ''])
            ->assertStatus(422);
    }

    public function test_store_creates_note_actionlog()
    {
        $actor = User::factory()->superuser()->create();
        $maintenance = Maintenance::factory()->create();

        $this->actingAsForApi($actor)
            ->postJson(route('api.maintenances.notes.store', $maintenance), ['note' => 'Important note'])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertDatabaseHas('action_logs', [
            'item_type' => Maintenance::class,
            'item_id' => $maintenance->id,
            'action_type' => 'note added',
            'note' => 'Important note',
            'created_by' => $actor->id,
        ]);
    }

    public function test_store_returns_note_in_response()
    {
        $actor = User::factory()->superuser()->create();
        $maintenance = Maintenance::factory()->create();

        $response = $this->actingAsForApi($actor)
            ->postJson(route('api.maintenances.notes.store', $maintenance), ['note' => 'My note'])
            ->assertOk();

        $this->assertEquals('My note', $response->json('payload.note'));
        $this->assertEquals($maintenance->id, $response->json('payload.item_id'));
    }
}
