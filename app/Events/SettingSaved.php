<?php

namespace App\Events;

use App\Models\Setting;

class SettingSaved
{
    public $settings;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Setting $settings
     */
    public function __construct(Setting $settings)
    {
        $this->settings = $settings;
    }
}