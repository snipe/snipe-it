<?php

namespace Tests\Feature\Maintenances\Ui;

use App\Models\Asset;
use App\Models\Maintenance;
use App\Models\MaintenanceType;
use App\Models\User;
use Tests\TestCase;

/**
 * Covers the bulk-delete endpoint on BulkMaintenanceTypesController.
 * Same in-use guard as the per-row destroy: a type with referring
 * maintenances is skipped and its skip surfaces on the
 * multi_error_messages flash; unused siblings in the same batch still
 * get deleted so a partial-success batch applies the safe rows and
 * flags the unsafe ones by name.
 */
class BulkMaintenanceTypeDeleteTest extends TestCase
{
    public function test_bulk_delete_requires_permission()
    {
        $type = MaintenanceType::factory()->create();

        $this->actingAs(User::factory()->create())
            ->post(route('maintenance-types.bulk.delete'), ['ids' => [$type->id]])
            ->assertForbidden();

        $this->assertDatabaseHas('maintenance_types', ['id' => $type->id, 'deleted_at' => null]);
    }

    public function test_bulk_delete_removes_selected_unused_types()
    {
        $doomed = MaintenanceType::factory()->count(3)->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('maintenance-types.bulk.delete'), [
                'ids' => $doomed->pluck('id')->all(),
            ])
            ->assertRedirect(route('maintenance-types.index'))
            ->assertSessionHas('success')
            ->assertSessionMissing('multi_error_messages');

        $doomed->each(fn ($t) => $this->assertSoftDeleted('maintenance_types', ['id' => $t->id]));
    }

    public function test_bulk_delete_skips_types_still_in_use()
    {
        $inUse = MaintenanceType::factory()->create();
        Maintenance::factory()->create([
            'maintenance_type_id' => $inUse->id,
            'item_id' => Asset::factory()->create()->id,
            'item_type' => Asset::class,
        ]);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('maintenance-types.bulk.delete'), [
                'ids' => [$inUse->id],
            ])
            ->assertRedirect(route('maintenance-types.index'))
            ->assertSessionMissing('success')
            ->assertSessionHas('multi_error_messages');

        $this->assertDatabaseHas('maintenance_types', ['id' => $inUse->id, 'deleted_at' => null]);
    }

    public function test_bulk_delete_handles_mixed_batch()
    {
        $unused = MaintenanceType::factory()->count(2)->create();
        $inUse = MaintenanceType::factory()->create();
        Maintenance::factory()->create([
            'maintenance_type_id' => $inUse->id,
            'item_id' => Asset::factory()->create()->id,
            'item_type' => Asset::class,
        ]);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('maintenance-types.bulk.delete'), [
                'ids' => array_merge($unused->pluck('id')->all(), [$inUse->id]),
            ])
            ->assertRedirect(route('maintenance-types.index'))
            ->assertSessionHas('success')
            ->assertSessionHas('multi_error_messages');

        $unused->each(fn ($t) => $this->assertSoftDeleted('maintenance_types', ['id' => $t->id]));
        $this->assertDatabaseHas('maintenance_types', ['id' => $inUse->id, 'deleted_at' => null]);
    }

    public function test_bulk_delete_skips_missing_ids_without_crashing()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('maintenance-types.bulk.delete'), [
                'ids' => [999999],
            ])
            ->assertRedirect(route('maintenance-types.index'))
            ->assertSessionHas('multi_error_messages');
    }
}
