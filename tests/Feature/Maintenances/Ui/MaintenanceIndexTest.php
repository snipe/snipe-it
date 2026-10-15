<?php

namespace Tests\Feature\Maintenances\Ui;

use App\Models\User;
use Tests\TestCase;

class MaintenanceIndexTest extends TestCase
{
    public function test_page_renders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('maintenances.index'))
            ->assertOk();
    }

    public function test_page_renders_with_array_shaped_query_param_probes()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get('/maintenances?completed[$ptt]=true&upcoming_status[$ptt]=overdue')
            ->assertOk();
    }
}
