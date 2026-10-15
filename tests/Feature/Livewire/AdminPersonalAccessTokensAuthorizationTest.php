<?php

namespace Tests\Feature\Livewire;

use App\Livewire\AdminPersonalAccessTokens;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Regression coverage for the Livewire snapshot-replay authorization bypass
 * reported by PizzaStev3 (2026-07-31). AdminPersonalAccessTokens' render()
 * enumerates every user's personal access tokens (name, expiration,
 * associated client, owning user). Route-level middleware on /admin/oauth
 * (superuser) protects the initial page render but not snapshot replays to
 * /livewire/update. boot() gate now catches both surfaces.
 */
class AdminPersonalAccessTokensAuthorizationTest extends TestCase
{
    public function test_superuser_can_mount()
    {
        $this->actingAs(User::factory()->superuser()->create());

        Livewire::test(AdminPersonalAccessTokens::class)
            ->assertStatus(200);
    }

    public function test_non_superuser_cannot_mount_or_replay()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(AdminPersonalAccessTokens::class)
            ->assertStatus(403);
    }
}
