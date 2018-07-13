<?php

namespace App\Console\Commands;

use App\Models\Setting;
use DB;
use Mail;
use App\Helpers\Helper;

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
        if ((Setting::getSettings()->alert_email!='')  && (Setting::getSettings()->alerts_enabled==1)) {

            $data['data'] = Helper::checkLowInventory();
            $data['count'] = count($data['data']);

            if (count($data['data']) > 0) {
                \Mail::send('emails.low-inventory', $data, function ($m) {
                    $m->to(explode(',', Setting::getSettings()->alert_email), Setting::getSettings()->site_name);
                    $m->replyTo(config('mail.reply_to.address'), config('mail.reply_to.name'));
                    $m->subject(trans('mail.Low_Inventory_Report'));
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
