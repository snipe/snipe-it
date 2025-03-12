<?php

namespace Tests\Feature\Users\Ui;

use App\Models\User;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    public function testPageRenders()
    {
        $admin = User::factory()->createUsers()->create();
        $response = $this->actingAs(User::factory()->superuser()->create())
            ->get(route('users.create'))
            ->assertOk();
        $response->assertDontSee($admin->first_name);
        $response->assertDontSee($admin->last_name);
        $response->assertDontSee($admin->email);
    }
}
