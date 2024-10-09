<?php

namespace Tests\Feature\Settings;

use App\Models\Asset;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Setting;


class SecuritySettingTest extends TestCase
{
    public function testPermissionRequiredToViewSecuritySettings()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('settings.security.index'))
            ->assertForbidden();
    }

}
