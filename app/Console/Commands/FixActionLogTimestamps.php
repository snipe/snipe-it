<?php

namespace App\Console\Commands;

use App\Models\Actionlog;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class FixActionLogTimestamps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:fix-action-log-timestamps {--dryrun : Run the sync process but don\'t update the database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $dryrun = false;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('dryrun')) {
            $this->dryrun = true;
        }

        if ($this->dryrun) {
            $this->info('This is a DRY RUN - no changes will be saved.');
        }

        // Logs that were improperly timestamped should have created_at in the 1970s
        $logs = Actionlog::whereYear('created_at', '1970')->get();

        $this->info('Found ' . $logs->count() . ' logs with incorrect timestamps:');

        $this->table(
            ['ID', 'Created At', 'Updated At'],
            $logs->map(function ($log) {
                return [
                    $log->id,
                    $log->created_at,
                    $log->updated_at,
                ];
            })
        );

        // @todo: get confirmation?

        foreach ($logs as $log) {
            if (!$this->dryrun){
                $this->line(vsprintf('Updating log id:%s from %s to %s', [$log->id, $log->created_at, $log->updated_at]));

                Model::withoutTimestamps(function () use ($log) {
                    $log->created_at = $log->updated_at;
                    $log->saveQuietly();
                });
            } else {
                $this->line(vsprintf('DRYRUN: Updating log id:%s from %s to %s', [$log->id, $log->created_at, $log->updated_at]));
            }
        }
    }
}
