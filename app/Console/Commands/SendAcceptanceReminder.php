<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Models\CheckoutAcceptance;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\CheckoutAssetNotification;
use App\Notifications\CurrentInventory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendAcceptanceReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:acceptance-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will resend users with unaccepted assets a reminder to accept or decline them.';

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
        $acceptances = CheckoutAcceptance::pending()->where('checkoutable_type', 'App\Models\Asset')->with(['assignedTo', 'checkoutable.assignedTo', 'checkoutable.model', 'checkoutable.adminuser'])->get();

        $count = 0;
        $unacceptedAssets = $acceptances
            ->filter(function($acceptance) {
                return $acceptance->checkoutable_type == 'App\Models\Asset';
            })
            ->map(function($acceptance) {
                return ['assetItem' => $acceptance->checkoutable, 'acceptance' => $acceptance];
            });

        foreach($unacceptedAssets as $unacceptedAsset) {
            if ($unacceptedAsset['acceptance']->assignedTo) {

                if (!$unacceptedAsset['acceptance']->assignedTo->locale) {
                    Notification::locale(Setting::getSettings()->locale)->send(
                        $unacceptedAsset['acceptance']->assignedTo,
                        new CheckoutAssetNotification($unacceptedAsset['assetItem'], $unacceptedAsset['acceptance']->assignedTo, $unacceptedAsset['assetItem']->adminuser, $unacceptedAsset['acceptance'], '')
                    );
                } else {
                    Notification::send(
                        $unacceptedAsset['acceptance']->assignedTo,
                        new CheckoutAssetNotification($unacceptedAsset['assetItem'], $unacceptedAsset['acceptance']->assignedTo, $unacceptedAsset['assetItem']->adminuser, $unacceptedAsset['acceptance'], '')
                    );
                }
                $count++;
            }
        }

        if ($unacceptedAsset['acceptance']->assignedTo->email == ''){
            return "no email";
        }



        $this->info($count.' users notified.');
    }
}
