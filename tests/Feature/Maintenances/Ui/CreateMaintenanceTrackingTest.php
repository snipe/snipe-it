<?php

namespace Tests\Feature\Maintenances\Ui;

use App\Models\Asset;
use App\Models\MaintenanceType;
use App\Models\User;
use Tests\TestCase;

class CreateMaintenanceTrackingTest extends TestCase
{
    public function test_checkout_snapshot_is_captured_when_asset_is_checked_out()
    {
        $actor = User::factory()->superuser()->create();
        $assignedUser = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($assignedUser)->create();
        $type = MaintenanceType::factory()->create();

        $this->actingAs($actor)
            ->post(route('maintenances.store'), [
                'name' => 'Snapshot Test',
                'selected_assets' => [$asset->id],
                'maintenance_type_id' => $type->id,
                'start_date' => '2026-01-01',
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('maintenances.index'));

        $this->assertDatabaseHas('maintenances', [
            'item_id' => $asset->id,
            'item_type' => Asset::class,
            'checked_out_to_id' => $assignedUser->id,
            'checked_out_to_type' => User::class,
        ]);
    }

    public function test_checkout_snapshot_is_null_when_asset_is_not_checked_out()
    {
        $actor = User::factory()->superuser()->create();
        $asset = Asset::factory()->create();
        $type = MaintenanceType::factory()->create();

        $this->actingAs($actor)
            ->post(route('maintenances.store'), [
                'name' => 'No Checkout Test',
                'selected_assets' => [$asset->id],
                'maintenance_type_id' => $type->id,
                'start_date' => '2026-01-01',
            ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('maintenances', [
            'item_id' => $asset->id,
            'item_type' => Asset::class,
            'checked_out_to_id' => null,
            'checked_out_to_type' => null,
        ]);
    }

    public function test_responsible_party_omitted_persists_as_null()
    {
        // Old behavior: the controller filled a missing / empty
        // responsible_party_id with the acting user via `?: auth()->id()`.
        // That silently defeated a deliberate clear on the create form
        // (issue #19452), so the controller now stores whatever the
        // form submits verbatim. The form template pre-selects the
        // acting user as a UX default so most creates still end up
        // with the acting user — but only when the user leaves the
        // pre-selection alone.
        $actor = User::factory()->superuser()->create();
        $asset = Asset::factory()->create();
        $type = MaintenanceType::factory()->create();

        $this->actingAs($actor)
            ->post(route('maintenances.store'), [
                'name' => 'RP Omit Test',
                'selected_assets' => [$asset->id],
                'maintenance_type_id' => $type->id,
                'start_date' => '2026-01-01',
            ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('maintenances', [
            'item_id' => $asset->id,
            'item_type' => Asset::class,
            'responsible_party_id' => null,
        ]);
    }

    public function test_responsible_party_can_be_set_to_another_user()
    {
        $actor = User::factory()->superuser()->create();
        $technician = User::factory()->create();
        $asset = Asset::factory()->create();
        $type = MaintenanceType::factory()->create();

        $this->actingAs($actor)
            ->post(route('maintenances.store'), [
                'name' => 'RP Explicit Test',
                'selected_assets' => [$asset->id],
                'maintenance_type_id' => $type->id,
                'responsible_party_id' => $technician->id,
                'start_date' => '2026-01-01',
            ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('maintenances', [
            'item_id' => $asset->id,
            'item_type' => Asset::class,
            'responsible_party_id' => $technician->id,
        ]);
    }

    public function test_maintenance_type_id_syncs_legacy_asset_maintenance_type()
    {
        $actor = User::factory()->superuser()->create();
        $asset = Asset::factory()->create();
        $type = MaintenanceType::factory()->create(['name' => 'Custom Calibration']);

        $this->actingAs($actor)
            ->post(route('maintenances.store'), [
                'name' => 'Type Sync Test',
                'selected_assets' => [$asset->id],
                'maintenance_type_id' => $type->id,
                'start_date' => '2026-01-01',
            ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('maintenances', [
            'item_id' => $asset->id,
            'item_type' => Asset::class,
            'maintenance_type_id' => $type->id,
            'asset_maintenance_type' => 'Custom Calibration',
        ]);
    }
}
