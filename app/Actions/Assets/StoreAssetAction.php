<?php

namespace App\Actions\Assets;

use App\Actions\BaseAction;
use App\Models\Setting;

class StoreAssetAction extends BaseAction
{
    public static function run($validatedData)
    {
        $settings = Setting::getSettings();
        foreach ($validatedData['asset_tag'] as $key => $tag) {

        }


    }
}