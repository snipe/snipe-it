<?php

namespace Tests\Feature\Settings;

use App\Models\Asset;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Setting;


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
            ->post(route('settings.alerts.save', ['ldap_enabled' => 1]))
            ->assertStatus(302)
            ->assertValid('alert_email')
            ->assertRedirect(route('settings.index'))
            ->assertSessionHasNoErrors();
        $this->followRedirects($response)->assertSee('alert-success');
    }

}
