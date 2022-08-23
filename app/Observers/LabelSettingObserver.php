<?php

namespace App\Observers;

use App\Models\LabelSettings;
use Illuminate\Support\Facades\Cache;

class LabelSettingObserver
{
    /**
     * Listen to the Label Settings saved event.
     *
     * @param LabelSettings $label_settings
     *
     * @return void
     */
    public function saved(LabelSettings $label_settings)
    {
        Cache::forget(LabelSettings::APP_LABEL_SETTINGS_KEY);
    }
}
