<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Models\License;
use App\Models\Recipients;
use App\Models\Setting;
use App\Notifications\ExpiringAssetsNotification;
use App\Notifications\SendUpcomingAuditNotification;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;

class SendUpcomingAuditReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:upcoming-audits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email/slack notifications for upcoming asset audits.';

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
        $settings = Setting::getSettings();

        if (($settings->alert_email != '') && ($settings->audit_warning_days) && ($settings->alerts_enabled == 1)) {

            // Send a rollup to the admin, if settings dictate
            $recipients = collect(explode(',', $settings->alert_email))->map(function ($item, $key) {
                return new \App\Models\Recipients\AlertRecipient($item);
            });

            // Assets due for auditing

            $assets = Asset::whereNotNull('next_audit_date')
                    ->DueOrOverdueForAudit($settings)
                    ->orderBy('last_audit_date', 'asc')->get();

            if ($assets->count() > 0) {
                $this->info(trans_choice('mail.upcoming-audits', $assets->count(),
                    ['count' => $assets->count(), 'threshold' => $settings->audit_warning_days]));
                \Notification::send($recipients, new SendUpcomingAuditNotification($assets, $settings->audit_warning_days));
                $this->info('Audit report sent to '.$settings->alert_email);
            } else {
                $this->info('No assets to be audited. No report sent.');
            }
        } elseif ($settings->alert_email == '') {
            $this->error('Could not send email. No alert email configured in settings');
        } elseif (! $settings->audit_warning_days) {
            $this->error('No audit warning days set in Admin Notifications. No mail will be sent.');
        } elseif ($settings->alerts_enabled != 1) {
            $this->info('Alerts are disabled in the settings. No mail will be sent');
        } else {
            $this->error('Something went wrong. :( ');
            $this->error('Admin Notifications Email Setting: '.$settings->alert_email);
            $this->error('Admin Audit Warning Setting: '.$settings->audit_warning_days);
            $this->error('Admin Alerts Emnabled: '.$settings->alerts_enabled);
        }
    }
}
