<?php

namespace App\Console\Commands;


use App\Models\Setting;
use App\Models\User;
use Illuminate\Console\Command;

class ResetDemoSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:demo-settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will reset the Snipe-IT demo settings back to default. ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->info('Resetting the demo settings.');
        $settings = Setting::first();
        $settings->per_page = 20;
        $settings->site_name = 'Snipe-IT Asset Management Demo';
        $settings->auto_increment_assets = 1;
        $settings->logo = 'snipe-logo.png';
        $settings->alert_email = 'service@snipe-it.io';
        $settings->login_note = 'Use `admin` / `password` to login to the demo.';
        $settings->header_color = null;
        $settings->barcode_type = 'QRCODE';
        $settings->default_currency = 'USD';
        $settings->brand = 2;
        $settings->ldap_enabled = 0;
        $settings->full_multiple_companies_support = 0;
        $settings->alt_barcode = 'C128';
        $settings->skin = '';
        $settings->email_domain = 'snipeitapp.com';
        $settings->email_format = 'filastname';
        $settings->username_format = 'filastname';
        $settings->date_display_format = 'D M d, Y';
        $settings->time_display_format = 'g:iA';
        $settings->thumbnail_max_h = '30';
        $settings->locale = 'en';
        $settings->version_footer = 'on';
        $settings->support_footer = null;
        $settings->saml_enabled = '0';
        $settings->saml_sp_x509cert = null;
        $settings->saml_idp_metadata = null;
        $settings->saml_attr_mapping_username = null;
        $settings->saml_forcelogin = '0';
        $settings->saml_slo = null;
        $settings->saml_custom_settings = null;


        $settings->save();

        if ($user = User::where('username', '=', 'admin')->first()) {
            $user->locale = 'en';
            $user->save();
        }

        \Storage::disk('public')->put('snipe-logo.png', file_get_contents(public_path('img/demo/snipe-logo.png')));
        \Storage::disk('public')->put('snipe-logo-lg.png', file_get_contents(public_path('img/demo/snipe-logo-lg.png')));

    }

}
