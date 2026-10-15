<?php

namespace Tests\Feature\Maintenances\Ui;

use App\Models\Asset;
use App\Models\Maintenance;
use App\Models\MaintenanceType;
use App\Models\User;
use Tests\TestCase;

/**
 * Web-side coverage for MaintenanceTypesController: show route renders
 * and gates on the view permission, and destroy honors the in-use
 * guard (mirrors the API-side destroy test in tests/Feature/Maintenances/
 * Api/MaintenanceTypesTest).
 */
class MaintenanceTypeControllerTest extends TestCase
{
    public function test_show_page_renders()
    {
        $type = MaintenanceType::factory()->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('maintenance-types.show', $type))
            ->assertOk()
            ->assertSeeText($type->name);
    }

    public function test_show_requires_permission()
    {
        $type = MaintenanceType::factory()->create();

        $this->actingAs(User::factory()->create())
            ->get(route('maintenance-types.show', $type))
            ->assertForbidden();
    }

    public function test_can_delete_unused_maintenance_type()
    {
        $type = MaintenanceType::factory()->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->delete(route('maintenance-types.destroy', $type))
            ->assertRedirect(route('maintenance-types.index'))
            ->assertSessionHas('success');

        $this->assertSoftDeleted($type);
    }

    public function test_cannot_delete_maintenance_type_that_is_in_use()
    {
        $type = MaintenanceType::factory()->create();
        Maintenance::factory()->create([
            'maintenance_type_id' => $type->id,
            'item_id' => Asset::factory()->create()->id,
            'item_type' => Asset::class,
        ]);

        $this->actingAs(User::factory()->superuser()->create())
            ->delete(route('maintenance-types.destroy', $type))
            ->assertRedirect(route('maintenance-types.index'))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('maintenance_types', ['id' => $type->id, 'deleted_at' => null]);
    }
}
