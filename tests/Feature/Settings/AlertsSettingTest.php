<?php

namespace Tests\Feature\Settings;

use Tests\TestCase;
use App\Models\User;


class AlertsSettingTest extends TestCase
{
    public function testPermissionRequiredToViewAlertSettings()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('settings.alerts.index'))
            ->assertForbidden();
    }

    public function testAdminCCEmailArrayCanBeSaved()
    {
        $response = $this->actingAs(User::factory()->superuser()->create())
            ->post(route('settings.alerts.save', ['alert_email' => 'me@example.com,you@example.com']))
            ->assertStatus(302)
            ->assertValid('alert_email')
            ->assertRedirect(route('settings.index'))
            ->assertSessionHasNoErrors();
        $this->followRedirects($response)->assertSee('alert-success');
    }

}
