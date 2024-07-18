<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Models\Recipients\AlertRecipient;
use App\Models\Setting;
use App\Notifications\SendUpcomingAuditNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
        $interval = $settings->audit_warning_days ?? 0;
        $today = Carbon::now();
        $interval_date = $today->copy()->addDays($interval);

        $assets = Asset::whereNull('deleted_at')->DueOrOverdueForAudit($settings)->orderBy('assets.next_audit_date', 'desc')->get();
        $this->info($assets->count().' assets must be audited in on or before '.$interval_date.' is deadline');


        if (($assets) && ($assets->count() > 0) && ($settings->alert_email != '')) {
            // Send a rollup to the admin, if settings dictate
            $recipients = collect(explode(',', $settings->alert_email))->map(function ($item) {
                return new AlertRecipient($item);
            });

            $this->info('Sending Admin SendUpcomingAuditNotification to: '.$settings->alert_email);
            \Notification::send($recipients, new SendUpcomingAuditNotification($assets, $settings->audit_warning_days));

        }

    }
}
