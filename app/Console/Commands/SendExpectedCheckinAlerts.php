<?php

namespace App\Console\Commands;


use App\Models\Asset;
use Illuminate\Console\Command;
use App\Notifications\ExpectedCheckinNotification;
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

        $whenNotify = Carbon::now()->addDays(7);
        $assets = Asset::with('assignedTo')->whereNotNull('expected_checkin')->where('expected_checkin', '<=', $whenNotify)->get();

        $this->info($whenNotify.' is deadline');
        $this->info($assets->count().' assets');

        foreach ($assets as $asset) {
            if ($asset->assignedTo  && $asset->checkoutOutToUser()) {
                $asset->assignedTo->notify((new ExpectedCheckinNotification($asset)));
                //$this->info($asset);
            }
        }





    }
}
