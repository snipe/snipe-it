<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Models\Recipients\AlertRecipient;
use App\Models\Setting;
use App\Notifications\ExpectedCheckinAdminNotification;
use App\Notifications\ExpectedCheckinNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendExpectedCheckinAlerts extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'snipeit:expected-checkin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for overdue or upcoming expected checkins.';

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
        $interval = $settings->audit_warning_days ?? 0;
        $today = Carbon::now();
        $interval_date = $today->copy()->addDays($interval);
        
        $assets = Asset::whereNull('deleted_at')->DueOrOverdueForCheckin($settings)->orderBy('assets.expected_checkin', 'desc')->get();

        $this->info($assets->count().' assets must be checked in on or before '.$interval_date.' is deadline');


        foreach ($assets as $asset) {
            if ($asset->assignedTo && (isset($asset->assignedTo->email)) && ($asset->assignedTo->email!='') && $asset->checkedOutToUser()) {
                $this->info('Sending User ExpectedCheckinNotification to: '.$asset->assignedTo->email);
                $asset->assignedTo->notify((new ExpectedCheckinNotification($asset)));
            }
        }

        if (($assets) && ($assets->count() > 0) && ($settings->alert_email != '')) {
            // Send a rollup to the admin, if settings dictate
            $recipients = collect(explode(',', $settings->alert_email))->map(function ($item) {
                return new AlertRecipient($item);
            });

            $this->info('Sending Admin ExpectedCheckinNotification to: '.$settings->alert_email);
            \Notification::send($recipients, new ExpectedCheckinAdminNotification($assets));

        }
    }
}
