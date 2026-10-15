<?php

namespace Tests\Feature\Maintenances\Api;

use App\Models\Asset;
use App\Models\Maintenance;
use App\Models\MaintenanceType;
use App\Models\User;
use Tests\TestCase;

class MaintenanceTypesTest extends TestCase
{
    public function test_index_requires_permission()
    {
        $this->actingAsForApi(User::factory()->create())
            ->getJson(route('api.maintenance-types.index'))
            ->assertForbidden();
    }

    public function test_can_list_maintenance_types()
    {
        MaintenanceType::factory()->count(3)->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.maintenance-types.index'))
            ->assertOk()
            ->assertJsonStructure(['total', 'rows']);
    }

    public function test_can_show_maintenance_type()
    {
        $type = MaintenanceType::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.maintenance-types.show', $type))
            ->assertOk()
            ->assertJsonFragment(['name' => $type->name]);
    }

    public function test_can_create_maintenance_type()
    {
        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.maintenance-types.store'), ['name' => 'My Custom Type'])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertDatabaseHas('maintenance_types', ['name' => 'My Custom Type']);
    }

    public function test_create_requires_name()
    {
        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.maintenance-types.store'), [])
            ->assertStatusMessageIs('error');
    }

    public function test_can_update_maintenance_type()
    {
        $type = MaintenanceType::factory()->create(['name' => 'Old Name']);

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->putJson(route('api.maintenance-types.update', $type), ['name' => 'New Name'])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertDatabaseHas('maintenance_types', ['id' => $type->id, 'name' => 'New Name']);
    }

    public function test_can_delete_maintenance_type()
    {
        $type = MaintenanceType::factory()->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->deleteJson(route('api.maintenance-types.destroy', $type))
            ->assertOk()
            ->assertStatusMessageIs('success');

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

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->deleteJson(route('api.maintenance-types.destroy', $type))
            ->assertStatus(409)
            ->assertStatusMessageIs('error');

        $this->assertDatabaseHas('maintenance_types', ['id' => $type->id, 'deleted_at' => null]);
    }

    public function test_index_exposes_maintenances_count()
    {
        $type = MaintenanceType::factory()->create();
        Maintenance::factory()->count(2)->create([
            'maintenance_type_id' => $type->id,
            'item_id' => Asset::factory()->create()->id,
            'item_type' => Asset::class,
        ]);

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.maintenance-types.index'))
            ->assertOk()
            ->assertJsonFragment(['id' => $type->id, 'maintenances_count' => 2]);
    }
}
