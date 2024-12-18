<?php

namespace Tests\Feature\AssetMaintenances\Ui;

use App\Models\AssetMaintenance;
use App\Models\User;
use Tests\TestCase;

class ShowAssetMaintenanceTest extends TestCase
{
    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('maintenances.show', AssetMaintenance::factory()->create()->id))
            ->assertOk();
    }
}
