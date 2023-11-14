<?php

namespace Tests\Feature\Settings;

use App\Models\User;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class BrandingSettingsTest extends TestCase
{
    use InteractsWithSettings;

    public function testSiteNameIsRequired()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('settings.branding.save', ['site_name' => '']))
            ->assertInvalid('site_name');
    }
}
