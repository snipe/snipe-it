<?php

namespace Tests\Feature\AssetMaintenances\Ui;

use App\Models\AssetMaintenance;
use App\Models\User;
use Tests\TestCase;

class EditAssetMaintenanceTest extends TestCase
{
    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('maintenances.edit', AssetMaintenance::factory()->create()->id))
            ->assertOk();
    }
}
