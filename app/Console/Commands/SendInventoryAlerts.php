<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Mail\InventoryAlertMail;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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
        if(!$settings){
            throw new \RuntimeException('Settings not found');
        }

        if (($settings->alert_email != '') && ($settings->alerts_enabled == 1)) {
            $items = Helper::checkLowInventory();

            if (($items) && (count($items) > 0)) {
                $this->info(trans_choice('mail.low_inventory_alert', count($items)));
                // Send a rollup to the admin, if settings dictate
                $recipients = collect(explode(',', $settings->alert_email))
                    ->map(fn($item) => trim($item)) // Trim each email
                    ->all();

                Mail::to($recipients)->send(new InventoryAlertMail($items, $settings->alert_threshold));
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
