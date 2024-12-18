<?php

namespace Tests\Feature\Accessories\Ui;

use App\Models\Accessory;
use App\Models\User;
use Tests\TestCase;

class ShowAccessoryTest extends TestCase
{
    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('accessories.show', Accessory::factory()->create()->id))
            ->assertOk();
    }
}
