<?php

namespace Tests\Feature\Settings;

use Tests\TestCase;
use App\Models\User;


class LdapSettingsTests extends TestCase
{
    public function testPermissionRequiredToViewLdapSettings()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('settings.ldap.index'))
            ->assertForbidden();
    }

    public function testLdapSettingsCanBeSaved()
    {
        $response = $this->actingAs(User::factory()->superuser()->create())
            ->post(route('settings.ldap.save', ['ldap_enabled' => 1]))
            ->assertStatus(302)
            ->assertValid('alert_email')
            ->assertRedirect(route('settings.index'))
            ->assertSessionHasNoErrors();
        $this->followRedirects($response)->assertSee('alert-success');
    }

}
