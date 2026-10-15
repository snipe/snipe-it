<?php

namespace App\Console\Commands;

use App\Mail\UnacceptedAssetReminderMail;
use App\Models\Accessory;
use App\Models\Asset;
use App\Models\CheckoutAcceptance;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\LicenseSeat;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Exception\TransportException;

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
    protected $description = 'This will resend users with unaccepted items a reminder to accept or decline them.';

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
        $pending = CheckoutAcceptance::query()
            ->with([
                'checkoutable' => function (MorphTo $morph) {
                    $morph->morphWith([
                        Asset::class => ['model.category', 'assignedTo', 'adminuser', 'company', 'checkouts'],
                        Accessory::class => ['category', 'company', 'checkouts'],
                        LicenseSeat::class => ['user', 'license', 'checkouts'],
                        Component::class => ['assignedTo', 'company', 'checkouts'],
                        Consumable::class => ['company', 'checkouts'],
                    ]);
                },
                'assignedTo',
            ])
            ->whereHasMorph(
                'checkoutable',
                [Asset::class, Accessory::class, LicenseSeat::class, Component::class, Consumable::class],
                fn ($q) => $q->whereNull('accepted_at')
                    ->whereNull('declined_at')
            )
            ->pending()
            ->get();

        $count = 0;
        $failed = 0;
        $unacceptedAssetGroups = $pending
            ->map(function ($acceptance) {
                return ['assetItem' => $acceptance->checkoutable, 'acceptance' => $acceptance];
            })
            ->groupBy(function ($item) {
                return $item['acceptance']->assignedTo ? $item['acceptance']->assignedTo->id : '';
            });
        $no_email_list = [];

        foreach ($unacceptedAssetGroups as $unacceptedAssetGroup) {
            // The [0] is weird, but it allows for the item_count to work and grabs the appropriate info for each user.
            // Collapsing and flattening the collection doesn't work above.
            $acceptance = $unacceptedAssetGroup[0]['acceptance'];

            $locale = $acceptance->assignedTo?->locale;
            $email = $acceptance->assignedTo?->email;

            if (! $email) {
                $no_email_list[] = [
                    'id' => $acceptance->assignedTo?->id,
                    'name' => $acceptance->assignedTo?->display_name,
                ];

                continue;
            }

            $item_count = $unacceptedAssetGroup->count();

            try {
                if ($locale) {
                    Mail::to($email)->send((new UnacceptedAssetReminderMail($acceptance, $item_count))->locale($locale));
                } else {
                    Mail::to($email)->send((new UnacceptedAssetReminderMail($acceptance, $item_count)));
                }
                $count++;
            } catch (TransportException $e) {
                $failed++;
                $message = 'Failed to send acceptance reminder to '.$email.': '.$e->getMessage();
                Log::warning($message);
                $this->error($message);
            }
        }

        $this->info($count.' users notified.');
        if ($failed > 0) {
            $this->warn($failed.' reminder(s) failed to send due to mail transport errors. See log for details.');
        }
        $headers = ['ID', 'Name'];
        $rows = [];

        foreach ($no_email_list as $user) {
            $rows[] = [$user['id'], $user['name']];
        }

        if (! empty($rows)) {
            $this->info('The following users do not have an email address:');
            $this->table($headers, $rows);
        }

        return 0;
    }
}
