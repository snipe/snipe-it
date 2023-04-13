<?php

namespace Tests\Support;

trait InteractsWithSettings
{
    protected Settings $settings;

    public function setUpSettings()
    {
        $this->settings = Settings::initialize();
    }
}
