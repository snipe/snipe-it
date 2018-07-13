<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Models\License;
use App\Models\Setting;
use DB;

use Illuminate\Console\Command;

class SendExpirationAlerts extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'snipeit:expiring-alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for expiring warrantees and service agreements, and sends out an alert email.';

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
    public function fire()
    {

        // Expiring Assets
        $expiring_assets = Asset::getExpiringWarrantee(Setting::getSettings()->alert_interval);
        $this->info(count($expiring_assets).' expiring assets');

        $asset_data['count'] =  count($expiring_assets);
        $asset_data['email_content'] ='';
        $now = date("Y-m-d");


        foreach ($expiring_assets as $asset) {

            $expires = $asset->present()->warrantee_expires();
            $difference =  round(abs(strtotime($expires) - strtotime($now))/86400);

            if ($difference > 30) {
                $asset_data['email_content'] .= '<tr style="background-color: #fcffa3;">';
            } else {
                $asset_data['email_content'] .= '<tr style="background-color:#d9534f;">';
            }
            $asset_data['email_content'] .= '<td><a href="'.config('app.url').'/hardware/'.e($asset->id).'/view">';
            $asset_data['email_content'] .= $asset->present()->name().'</a></td><td>'.e($asset->asset_tag).'</td>';
            $asset_data['email_content'] .= '<td>'.e($asset->present()->warrantee_expires()).'</td>';
            $asset_data['email_content'] .= '<td>'.$difference.' '.trans('mail.days').'</td>';
            $asset_data['email_content'] .= '<td>'.($asset->supplier ? e($asset->supplier->name) : '').'</td>';
            $asset_data['email_content'] .= '<td>'.($asset->assignedTo ? e($asset->assignedTo->present()->name()) : '').'</td>';
            $asset_data['email_content'] .= '</tr>';
        }

        // Expiring licenses
        $expiring_licenses = License::getExpiringLicenses(Setting::getSettings()->alert_interval);
        $this->info(count($expiring_licenses).' expiring licenses');


        $license_data['count'] =  $expiring_licenses->count();
        $license_data['email_content'] = '';

        foreach ($expiring_licenses as $license) {
            $expires = $license->expiration_date;
            $difference =  round(abs(strtotime($expires) - strtotime($now))/86400);

            if ($difference > 30) {
                $license_data['email_content'] .= '<tr style="background-color: #fcffa3;">';
            } else {
                $license_data['email_content'] .= '<tr style="background-color:#d9534f;">';
            }
                $license_data['email_content'] .= '<td><a href="'.route('licenses.show', $license->id).'">';
                $license_data['email_content'] .= $license->name.'</a></td>';
                $license_data['email_content'] .= '<td>'.$license->expiration_date.'</td>';
                $license_data['email_content'] .= '<td>'.$difference.' days</td>';
                $license_data['email_content'] .= '</tr>';
        }

        if ((Setting::getSettings()->alert_email!='')  && (Setting::getSettings()->alerts_enabled==1)) {


            if (count($expiring_assets) > 0) {
                $this->info('Report sent to '.Setting::getSettings()->alert_email);
                \Mail::send('emails.expiring-assets-report', $asset_data, function ($m) {
                    $m->to(explode(',', Setting::getSettings()->alert_email), Setting::getSettings()->site_name);
                    $m->replyTo(config('mail.reply_to.address'), config('mail.reply_to.name'));
                    $m->subject(trans('mail.Expiring_Assets_Report'));
                });

            }

            if (count($expiring_licenses) > 0) {
                $this->info('Report sent to '.Setting::getSettings()->alert_email);
                \Mail::send('emails.expiring-licenses-report', $license_data, function ($m) {
                    $m->to(explode(',', Setting::getSettings()->alert_email), Setting::getSettings()->site_name);
                    $m->replyTo(config('mail.reply_to.address'), config('mail.reply_to.name'));
                    $m->subject(trans('mail.Expiring_Licenses_Report'));
                });

            }


        } else {

            if (Setting::getSettings()->alert_email=='') {
                echo "Could not send email. No alert email configured in settings. \n";
            } elseif (Setting::getSettings()->alerts_enabled!=1) {
                echo "Alerts are disabled in the settings. No mail will be sent. \n";
            }

        }




    }
}
