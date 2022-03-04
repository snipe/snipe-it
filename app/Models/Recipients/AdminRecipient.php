<?php

namespace App\Models\Recipients;

use App\Models\Setting;

class AdminRecipient extends Recipient
{
    public function __construct()
    {
        $settings = Setting::getSettings();
        $this->email = trim($settings->admin_cc_email);
    }
}
