<?php

namespace Tests\Feature\Notes;

use App\Models\Asset;
use App\Models\Maintenance;
use App\Models\User;
use Tests\TestCase;

class CreateNotesTest extends TestCase
{
    public function test_requires_permission()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('notes.store'))
            ->assertForbidden();
    }

    public function test_validation()
    {
        $asset = Asset::factory()->create();

        $this->actingAs(User::factory()->editAssets()->create())
            ->post(route('notes.store'), [
                'id' => $asset->id,
                // should be more...
            ])
            ->assertSessionHas('errors');
    }

    public function test_asset_must_exist()
    {
        $this->actingAs(User::factory()->editAssets()->create())
            ->post(route('notes.store'), [
                'id' => 999_999,
                'type' => 'asset',
                'note' => 'my note',
            ])
            ->assertStatus(302);
    }

    public function test_can_create_note_for_asset()
    {
        $actor = User::factory()->editAssets()->create();

        $asset = Asset::factory()->create();

        $this->actingAs($actor)
            ->withHeader('User-Agent', 'Custom User Agent For Test')
            ->post(route('notes.store'), [
                '_token' => '_token-to-simulate-request-from-gui',
                'id' => $asset->id,
                'type' => 'asset',
                'note' => 'my special note',
            ])
            ->assertRedirect(route('hardware.show', $asset->id).'#notes')
            ->assertSessionHas('success', trans('general.note_added'));

        $this->assertDatabaseHas('action_logs', [
            'created_by' => $actor->id,
            'action_type' => 'note added',
            'target_id' => null,
            'target_type' => null,
            'note' => 'my special note',
            'item_type' => Asset::class,
            'item_id' => $asset->id,
            'action_source' => 'gui',
            'user_agent' => 'Custom User Agent For Test',
        ]);
    }

    public function test_can_create_note_for_maintenance()
    {
        $actor = User::factory()->editAssets()->create();
        $maintenance = Maintenance::factory()->create();

        $this->actingAs($actor)
            ->post(route('notes.store'), [
                'id' => $maintenance->id,
                'type' => 'maintenance',
                'note' => 'maintenance note text',
            ])
            ->assertRedirect(route('maintenances.show', $maintenance->id).'#notes')
            ->assertSessionHas('success', trans('general.note_added'));

        $this->assertDatabaseHas('action_logs', [
            'created_by' => $actor->id,
            'action_type' => 'note added',
            'note' => 'maintenance note text',
            'item_type' => Maintenance::class,
            'item_id' => $maintenance->id,
        ]);
    }

    public function test_maintenance_note_requires_asset_update_permission()
    {
        $maintenance = Maintenance::factory()->create();

        $this->actingAs(User::factory()->create())
            ->post(route('notes.store'), [
                'id' => $maintenance->id,
                'type' => 'maintenance',
                'note' => 'should fail',
            ])
            ->assertForbidden();
    }

    public function test_maintenance_must_exist_for_note()
    {
        $this->actingAs(User::factory()->editAssets()->create())
            ->post(route('notes.store'), [
                'id' => 999_999,
                'type' => 'maintenance',
                'note' => 'ghost note',
            ])
            ->assertStatus(302);
    }
}
