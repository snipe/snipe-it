<?php

namespace Tests\Feature\Settings;

use App\Models\Asset;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Setting;


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
