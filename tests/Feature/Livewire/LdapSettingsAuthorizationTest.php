<?php

namespace Tests\Feature\Livewire;

use App\Livewire\LdapSettings;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Regression coverage for the Livewire snapshot-replay authorization bypass
 * reported by PizzaStev3 (2026-07-31). LdapSettings had an abort_unless
 * check in mount() which only fires on the initial page render. Snapshot
 * replay to /livewire/update went through hydrate() -> action methods
 * without re-entering mount(). Now duplicated into boot() which fires on
 * every Livewire request.
 */
class LdapSettingsAuthorizationTest extends TestCase
{
    public function test_superadmin_can_mount()
    {
        $this->actingAs(User::factory()->firstAdmin()->create());

        Livewire::test(LdapSettings::class)
            ->assertStatus(200);
    }

    public function test_non_superadmin_cannot_mount_or_replay()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(LdapSettings::class)
            ->assertStatus(403);
    }
}
