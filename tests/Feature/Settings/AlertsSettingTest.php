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
        $asset = Asset::factory()->create();
        $this->actingAs(User::factory()->create())
            ->get(route('settings.alerts.index'))
            ->assertForbidden();
    }

}
