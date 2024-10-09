<?php

namespace Tests\Feature\Settings;

use Tests\TestCase;
use App\Models\User;


class LdapSettingsTest extends TestCase
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
            ->post(route('settings.ldap.save', [
                'ldap_enabled' => 1,
                'ldap_username_field' => 'samaccountname',
                'ldap_filter' => 'uid=',
            ]))
            ->assertStatus(302)
            ->assertValid('ldap_enabled')
            ->assertRedirect(route('settings.index'))
            ->assertSessionHasNoErrors();
        $this->followRedirects($response)->assertSee('alert-success');
    }

    public function testLdapSettingsAreValidatedCorrectly()
    {
        $response = $this->actingAs(User::factory()->superuser()->create())
            ->from(route('settings.ldap.index'))
            ->post(route('settings.ldap.save', [
                'ldap_enabled' => 1,
                'ldap_username_field' => 'sAMAccountName',
                'ldap_filter' => 'uid=',
            ]))
            ->assertStatus(302)
            ->assertRedirect(route('settings.ldap.index'))
            ->assertSessionHasErrors();
        $this->followRedirects($response)->assertSee('alert-danger');
    }

}
