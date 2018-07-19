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
            $recipient = new \App\Models\Recipients\AlertRecipient();

            if (($items) && (count($items) > 0) && ($settings->alert_email!='')) {
                $recipient->notify(new InventoryAlert($items, $settings->alert_threshold));
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
