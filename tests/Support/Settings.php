<?php

namespace Tests\Support;

use App\Models\Setting;

class Settings
{
    private Setting $setting;
    
    private function __construct()
    {
        $this->setting = Setting::factory()->create();
    }

    public static function initialize()
    {
        return new self();
    }

    public function enableMultipleFullCompanySupport()
    {
        $this->update(['full_multiple_companies_support' => 1]);
    }

    public function set(array $attributes)
    {
        $this->update($attributes);
    }

    private function update(array $attributes)
    {
        Setting::unguarded(fn() => $this->setting->update($attributes));
    }
}
