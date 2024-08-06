<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

final class DashboardTest extends TestCase
{
    public function testUsersWithoutAdminAccessAreRedirected(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('home'))
            ->assertRedirect(route('view-assets'));
    }
}
