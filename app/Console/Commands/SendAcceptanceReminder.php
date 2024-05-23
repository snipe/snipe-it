<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Models\CheckoutAcceptance;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\CheckoutAssetNotification;
use App\Notifications\CurrentInventory;
use App\Notifications\UnacceptedAssetReminderNotification;
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
        $pending = CheckoutAcceptance::pending()->where('checkoutable_type', 'App\Models\Asset')
                                                ->whereHas('checkoutable', function($query) {
                                                    $query->where('archived', 0);
                                                })
                                                ->with(['assignedTo', 'checkoutable.assignedTo', 'checkoutable.model', 'checkoutable.adminuser'])
                                                ->get();

        $count = 0;
        $unacceptedAssetGroups = $pending
            ->filter(function($acceptance) {
                return $acceptance->checkoutable_type == 'App\Models\Asset';
            })
            ->map(function($acceptance) {
                return ['assetItem' => $acceptance->checkoutable, 'acceptance' => $acceptance];
            })
            ->groupBy(function($item) {
                return $item['acceptance']->assignedTo ? $item['acceptance']->assignedTo->id : '';
            });

        $no_mail_address = [];

        foreach($unacceptedAssetGroups as $unacceptedAssetGroup) {
            $item_count = $unacceptedAssetGroup->count();
            foreach ($unacceptedAssetGroup as $unacceptedAsset) {
//            if ($unacceptedAsset['acceptance']->assignedTo->email == ''){
//                $no_mail_address[] = $unacceptedAsset['checkoutable']->assignedTo->present()->fullName;
//            }
                if ($unacceptedAsset['acceptance']->assignedTo) {

                    if (!$unacceptedAsset['acceptance']->assignedTo->locale) {
                        Notification::locale(Setting::getSettings()->locale)->send(
                            $unacceptedAsset['acceptance']->assignedTo,
                            new UnacceptedAssetReminderNotification($unacceptedAsset['assetItem'], $count)
                        );
                    } else {
                        Notification::send(
                            $unacceptedAsset['acceptance']->assignedTo,
                            new UnacceptedAssetReminderNotification($unacceptedAsset, $item_count)
                        );
                    }
                    $count++;
                }
            }
        }

        if (!empty($no_mail_address)) {
            foreach($no_mail_address as $user) {
                return $user.' has no email.';
            }


        }



        $this->info($count.' users notified.');
    }
}
