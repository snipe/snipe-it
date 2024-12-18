<?php

namespace Tests\Feature\Groups\Ui;

use App\Models\User;
use Tests\TestCase;

class CreateGroupTest extends TestCase
{
    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('groups.create'))
            ->assertOk();
    }
}
