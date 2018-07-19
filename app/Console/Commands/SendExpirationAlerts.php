<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Models\License;
use App\Models\Setting;
use DB;
use App\Notifications\Exp;
use App\Notifications\ExpiringLicenseNotification;
use App\Notifications\ExpiringAssetsNotification;

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

        $threshold = Setting::getSettings()->alert_interval;
        // Expiring Assets
        $assets = Asset::getExpiringWarrantee(Setting::getSettings()->alert_interval);
        $this->info($assets->count().' assets expiring within '.Setting::getSettings()->alert_interval.' days');

        // Expiring licenses
        $licenses = License::getExpiringLicenses($threshold);
        $this->info($licenses->count().' licenses expiring within '.Setting::getSettings()->alert_interval.' days');
        $recipient = new \App\Models\Recipients\AlertRecipient();

        if ((Setting::getSettings()->alert_email!='')  && (Setting::getSettings()->alerts_enabled==1)) {

            if ($assets->count() > 0) {
                // Send a rollup to the admin, if settings dictate
                $recipient->notify(new ExpiringAssetsNotification($assets, $threshold));
            }

            if ($licenses->count() > 0) {
                $recipient->notify(new ExpiringLicenseNotification($licenses, $threshold));
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
