<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use InteractsWithSettings;

    public function testUsersWithoutAdminAccessAreRedirected()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('home'))
            ->assertRedirect(route('view-assets'));
    }
}
