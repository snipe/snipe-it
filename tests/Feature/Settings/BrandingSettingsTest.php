<?php

namespace Tests\Feature\Settings;

use App\Models\User;
use Tests\TestCase;

class BrandingSettingsTest extends TestCase
{
    public function testSiteNameIsRequired()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('settings.branding.save', ['site_name' => '']))
            ->assertInvalid('site_name');
    }
}
