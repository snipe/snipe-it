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

    // @todo:
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private bool $dryrun = false;

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

        // @todo: handle created_by being null...

        $this->info('Found ' . $logs->count() . ' logs with incorrect timestamps:');

        $this->table(
            ['ID', 'Created By', 'Created At', 'Updated At'],
            $logs->map(function ($log) {
                return [
                    $log->id,
                    $log->created_by,
                    $log->created_at,
                    $log->updated_at,
                ];
            })
        );

        if (!$this->dryrun && !$this->confirm('Update these logs?')) {
            return 0;
        }

        if ($this->dryrun) {
            $this->info('DRY RUN. NOT ACTUALLY UPDATING LOGS.');
        }

        foreach ($logs as $log) {
            $this->line(vsprintf('Updating log id:%s from %s to %s', [$log->id, $log->created_at, $log->updated_at]));
            $log->created_at = $log->updated_at;

            $createdBy = $this->getCreatedByAttributeFromSimilarLog($log);

            if ($createdBy) {
                $this->line(vsprintf('Updating log id:%s created_by to %s', [$log->id, $createdBy]));
                $log->created_by = $createdBy;
            } else {
                $this->line(vsprintf('No created_by found for log id:%s', [$log->id]));
            }

            if (!$this->dryrun) {
                Model::withoutTimestamps(function () use ($log) {
                    $log->saveQuietly();
                });
            }

            $this->newLine();
        }

        if ($this->dryrun) {
            $this->info('DRY RUN. NO CHANGES WERE ACTUALLY MADE.');
        }

        return 0;
    }

    private function getCreatedByAttributeFromSimilarLog(Actionlog $log): null|int
    {
        if (is_null($log->created_by)) {
            $similarLog = Actionlog::query()
                ->whereNotNull('created_by')
                ->where([
                    'action_type' => 'checkin from',
                    'note' => 'Bulk checkin items',
                    'target_id' => $log->target_id,
                    'target_type' => $log->target_type,
                    'created_at' => $log->updated_at,
                ])
                ->first();

            if ($similarLog) {
                return $similarLog->created_by;
            }

            return null;
        }
    }
}
