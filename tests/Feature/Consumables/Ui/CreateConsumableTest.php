<?php

namespace Tests\Feature\Consumables\Ui;

use App\Models\User;
use Tests\TestCase;

class CreateConsumableTest extends TestCase
{
    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('consumables.create'))
            ->assertOk();
    }
}
