<?php

namespace Tests\Feature\Manufacturers\Ui;

use App\Models\User;
use Tests\TestCase;

class CreateManufacturerTest extends TestCase
{
    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('manufacturers.create'))
            ->assertOk();
    }
}
