<?php

namespace Tests\Feature\Users\Ui;

use App\Models\User;
use Tests\TestCase;

class TwoFactorResetTest extends TestCase
{
    protected function enableSiteTwoFactor(): void
    {
        // Optional-mode ("1") lets the actor through the CheckForTwoFactor middleware
        // as long as they don't opt in, while still satisfying the resetTwoFactor policy
        // for an opted-in-and-enrolled target.
        $this->settings->set(['two_factor_enabled' => 1]);
    }

    protected function makeEnrolledTarget(): User
    {
        return User::factory()->create([
            'activated' => 1,
            'two_factor_optin' => 1,
            'two_factor_enrolled' => 1,
            'two_factor_secret' => 'target-seed',
        ]);
    }

    public function test_superuser_can_reset_another_users_two_factor()
    {
        $this->enableSiteTwoFactor();

        $actor = User::factory()->superuser()->create();
        $target = $this->makeEnrolledTarget();

        $this->actingAs($actor)
            ->post(route('users.two_factor_reset', $target))
            ->assertRedirect(route('users.show', $target))
            ->assertSessionHas('success');

        $target->refresh();
        $this->assertNull($target->two_factor_secret);
        $this->assertEquals(0, $target->two_factor_enrolled);

        $this->assertDatabaseHas('action_logs', [
            'item_type' => User::class,
            'item_id' => $target->id,
            'created_by' => $actor->id,
            'action_type' => '2FA reset',
        ]);
    }

    public function test_profile_renders_modal_when_two_factor_is_enrolled_and_enabled()
    {
        $this->enableSiteTwoFactor();

        $actor = User::factory()->superuser()->create();
        $target = $this->makeEnrolledTarget();

        $response = $this->actingAs($actor)->get(route('users.show', $target))->assertOk();
        $html = $response->getContent();

        $triggerCount = substr_count($html, 'data-target="#confirmTwoFactorResetModal"');
        $modalIdCount = substr_count($html, 'id="confirmTwoFactorResetModal"');

        $this->assertSame(1, $triggerCount, 'exactly one trigger button expected');
        $this->assertSame(1, $modalIdCount, 'exactly one modal container expected');
    }

    public function test_non_admin_cannot_reset_two_factor()
    {
        $this->enableSiteTwoFactor();

        $actor = User::factory()->create();
        $target = $this->makeEnrolledTarget();
        $originalSecret = $target->two_factor_secret;

        $this->actingAs($actor)
            ->post(route('users.two_factor_reset', $target))
            ->assertForbidden();

        $target->refresh();
        $this->assertSame($originalSecret, $target->two_factor_secret);
        $this->assertEquals(1, $target->two_factor_enrolled);
    }

    public function test_button_hidden_when_site_two_factor_is_off()
    {
        // NULL is the only "off" signal that survives both SQLite and MySQL.
        // The column is tinyInteger, so an empty string coerces to 0 on MySQL,
        // and the CheckForTwoFactor middleware then treats "0" as on-but-broken
        // and redirects (302), while on SQLite the empty string is stored as-is
        // and the middleware short-circuits (200). Local vs CI divergence.
        $this->settings->set(['two_factor_enabled' => null]);

        $actor = User::factory()->superuser()->create();
        $target = User::factory()->create([
            'activated' => 1,
            'two_factor_optin' => 1,
            'two_factor_enrolled' => 1,
            'two_factor_secret' => 'seed',
        ]);

        $this->actingAs($actor)
            ->get(route('users.show', $target))
            ->assertOk()
            ->assertDontSee('confirmTwoFactorResetModal');
    }

    public function test_button_hidden_when_target_has_no_two_factor_enrolled()
    {
        $this->enableSiteTwoFactor();

        $actor = User::factory()->superuser()->create();
        $target = User::factory()->create([
            'activated' => 1,
            'two_factor_enrolled' => 0,
        ]);

        $response = $this->actingAs($actor)->get(route('users.show', $target))->assertOk();
        $html = $response->getContent();

        $this->assertStringNotContainsString('data-target="#confirmTwoFactorResetModal"', $html);
        $this->assertStringNotContainsString('id="confirmTwoFactorResetModal"', $html);
    }
}
