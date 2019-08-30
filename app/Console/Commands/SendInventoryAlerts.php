<?php

namespace App\Console\Commands;

use App\Models\Setting;
use DB;
use Mail;
use App\Helpers\Helper;
use App\Notifications\InventoryAlert;

use Illuminate\Console\Command;

class SendInventoryAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:inventory-alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command checks for low inventory, and sends out an alert email.';

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

        if (($settings->alert_email!='')  && ($settings->alerts_enabled==1)) {

            $items = Helper::checkLowInventory();

            // Send a rollup to the admin, if settings dictate

            if (($items) && (count($items) > 0)) {
                $this->info(trans_choice('mail.low_inventory_alert', count($items)));
                // Send a rollup to the admin, if settings dictate
                $recipients = collect(explode(',', $settings->alert_email))->map(function ($item, $key) {
                    return new \App\Models\Recipients\AlertRecipient($item);
                });
                \Notification::send($recipients, new InventoryAlert($items, $settings->alert_threshold));
            }

        } else {
            if (Setting::getSettings()->alert_email=='') {
                $this->error('Could not send email. No alert email configured in settings');
            } elseif (Setting::getSettings()->alerts_enabled!=1) {
                $this->info('Alerts are disabled in the settings. No mail will be sent');
            }
        }


    }
}
