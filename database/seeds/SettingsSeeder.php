<?php
use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\User;


class SettingsSeeder extends Seeder
{
    public function run()
    {
        Setting::truncate();
        $settings = new Setting;
        $settings->per_page = 20;
        $settings->site_name = 'Snipe-IT Demo';
        $settings->auto_increment_assets = 1;
        $settings->logo = 'logo.png';
        $settings->alert_email = 'service@snipe-it.io';
        $settings->header_color = null;
        $settings->barcode_type = 'QRCODE';
        $settings->default_currency = 'USD';
        $settings->brand = 3;
        $settings->ldap_enabled = 0;
        $settings->full_multiple_companies_support = 0;
        $settings->alt_barcode = 'C128';
        $settings->skin = '';
        $settings->email_domain = 'example.org';
        $settings->email_format = 'filastname';
        $settings->username_format = 'filastname';
        $settings->date_display_format = 'D M d, Y';
        $settings->time_display_format = 'g:iA';
        $settings->thumbnail_max_h = '30';
        $settings->locale = 'en';
        $settings->version_footer = 'on';
        $settings->support_footer = 'on';
        $settings->pwd_secure_min = '8';
        $settings->save();

        if ($user = User::where('username', '=', 'admin')->first()) {
            $user->locale = 'en';
            $user->save();
        }
    }
}
