<?php

namespace Tests\Feature\Assets\Ui;

use App\Models\User;
use Tests\TestCase;

class StoreAssetsTest extends TestCase
{
    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('hardware.create'))
            ->assertOk();
    }
}
