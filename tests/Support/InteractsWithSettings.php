<?php

namespace Tests\Support;

use App\Models\Setting;

trait InteractsWithSettings
{
    protected Settings $settings;

    public function initializeSettings()
    {
        $this->settings = Settings::initialize();

        $this->beforeApplicationDestroyed(fn() => Setting::$_cache = null);
    }
}
