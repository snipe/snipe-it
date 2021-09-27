<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Models\License;
use App\Models\Recipients\AlertRecipient;
use App\Models\Setting;
use App\Notifications\ExpiringAssetsNotification;
use App\Notifications\ExpiringLicenseNotification;
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
        $settings = Setting::getSettings();
        $threshold = $settings->alert_interval;

        if (($settings->alert_email != '') && ($settings->alerts_enabled == 1)) {

            // Send a rollup to the admin, if settings dictate
            $recipients = collect(explode(',', $settings->alert_email))->map(function ($item, $key) {
                return new AlertRecipient($item);
            });

            // Expiring Assets
            $assets = Asset::getExpiringWarrantee($threshold);
            if ($assets->count() > 0) {
                $this->info(trans_choice('mail.assets_warrantee_alert', $assets->count(), ['count' => $assets->count(), 'threshold' => $threshold]));
                \Notification::send($recipients, new ExpiringAssetsNotification($assets, $threshold));
            }

            // Expiring licenses
            $licenses = License::getExpiringLicenses($threshold);
            if ($licenses->count() > 0) {
                $this->info(trans_choice('mail.license_expiring_alert', $licenses->count(), ['count' => $licenses->count(), 'threshold' => $threshold]));
                \Notification::send($recipients, new ExpiringLicenseNotification($licenses, $threshold));
            }
        } else {
            if ($settings->alert_email == '') {
                $this->error('Could not send email. No alert email configured in settings');
            } elseif (1 != $settings->alerts_enabled) {
                $this->info('Alerts are disabled in the settings. No mail will be sent');
            }
        }
    }
}
