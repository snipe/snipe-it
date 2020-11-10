<?php

namespace App\Console\Commands;

use App\Models\Actionlog;
use App\Models\Asset;
use Illuminate\Console\Command;

class FixMismatchedAssetsAndLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:fix-assets-and-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        $mismatch_count = 0;
        $assets = Asset::whereNotNull('assigned_to')->get();
        foreach ($assets as $asset) {

            // get the last checkout of the asset
            if ($checkout_log = Actionlog::where('target_type', '=', 'App\\Models\\User')
                ->where('action_type', '=', 'checkout')
                ->where('item_id', '=', $asset->id)
                ->orderBy('created_at', 'DESC')
                ->first()) {

                    // Now check for a subsequent checkin log - we want to ignore those
                    if (!$checkin_log = Actionlog::where('target_type', '=', 'App\\Models\\User')
                        ->where('action_type', '=', 'checkin from')
                        ->where('item_id', '=', $asset->id)
                        ->whereDate('created_at', '>', $checkout_log->created_at)
                        ->orderBy('created_at', 'DESC')
                        ->first()) {

                        // $this->info($checkout_log->id.' is checked out to '.$checkout_log->target_type.' '.$checkout_log->target_id.' and there is no subsequent checkin log.');


                        //print_r($asset);
                        if ($checkout_log->target_id != $asset->assigned_to) {
                            $this->error('Log ID: '.$checkout_log->id.' -- Asset ID '. $checkout_log->item_id.' SHOULD BE checked out to User '.$checkout_log->target_id.' but its assigned_to is '.$asset->assigned_to );
                            $mismatch_count++;
                        }
                    } else {
                        $this->info('Asset ID '.$asset->id.': There is a checkin '.$checkin_log->created_at.' after this checkout '.$checkout_log->created_at);

                    }

            }

        }
        $this->info($mismatch_count.' mismatched assets.');

    }
}
