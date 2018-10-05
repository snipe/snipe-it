<?php

namespace App\Console\Commands;


use App\Models\Asset;
use App\Models\Setting;
use Illuminate\Console\Command;
use App\Notifications\ExpectedCheckinNotification;
use App\Notifications\ExpectedCheckinAdminNotification;
use Carbon\Carbon;

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
        $settings = Setting::getSettings();
        $whenNotify = Carbon::now()->addDays(7);
        $assets = Asset::with('assignedTo')->whereNotNull('assigned_to')->whereNotNull('expected_checkin')->where('expected_checkin', '<=', $whenNotify)->get();

        $this->info($whenNotify.' is deadline');
        $this->info($assets->count().' assets');

        foreach ($assets as $asset) {
            if ($asset->assigned  && $asset->checkedOutToUser()) {
                $asset->assigned->notify((new ExpectedCheckinNotification($asset)));
            }
        }

        if (($assets) && ($assets->count() > 0) && ($settings->alert_email != '')) {
            // Send a rollup to the admin, if settings dictate
            $recipients = collect(explode(',', $settings->alert_email))->map(function ($item, $key) {
                return new \App\Models\Recipients\AlertRecipient($item);
            });
            \Notification::send($recipients, new ExpectedCheckinAdminNotification($assets));
        }





    }
}
