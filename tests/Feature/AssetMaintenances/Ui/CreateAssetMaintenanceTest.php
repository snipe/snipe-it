<?php

namespace Tests\Feature\AssetMaintenances\Ui;

use App\Models\User;
use Tests\TestCase;

class CreateAssetMaintenanceTest extends TestCase
{
    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('maintenances.create'))
            ->assertOk();
    }
}
