<?php
namespace App\Models\Recipients;

use App\Models\Setting;

class AlertRecipient extends Recipient{

    public function __construct()
    {
       $settings = Setting::getSettings();
       $this->email = $settings->alert_email;
    }

}
