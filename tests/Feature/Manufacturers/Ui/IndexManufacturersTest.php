<?php

namespace Tests\Feature\Manufacturers\Ui;

use App\Models\User;
use Tests\TestCase;

class IndexManufacturersTest extends TestCase
{
    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('manufacturers.index'))
            ->assertOk();
    }
}
