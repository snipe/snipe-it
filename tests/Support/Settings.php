<?php

namespace Tests\Support;

use App\Models\Setting;

class Settings
{
    private Setting $setting;
    
    public function __construct()
    {
        $this->setting = Setting::factory()->create();
    }

    public function enableMultipleFullCompanySupport()
    {
        $this->update(['full_multiple_companies_support' => 1]);
    }

    public function disableMultipleFullCompanySupport()
    {
        $this->update(['full_multiple_companies_support' => 0]);
    }

    private function update(array $attributes)
    {
        Setting::unguarded(fn() => $this->setting->update($attributes));
    }
}
