<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Actionlog;
use App\Models\Accessory;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\License;
use App\Models\Location;
use App\Models\User;

class CleanUpActionLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:clean-up-action-logs 
                            {--delete : This option will delete the action_logs in question, instead of counting them}
                            {--force : Delete the action_logs without having to confirm in terminal}
                            {--to-sql : Don\'t execute any queries, just output what those queries would be}';

    /**
     * The console command description.                                                                                                                                           *
     * @var string
     */
    protected $description = 'This command counts (or optionally deletes) any action_logs that refer to nonexist items or targets';

    /**                                                                                                                                                                           * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('delete') && $this->option('to-sql')) {
            $this->fail("Can't use both --delete and --to-sql at the same time");
        }
        if ($this->option('delete')) {
            if (!$this->option('force')) {
                if (!$this->confirm('Do you really want to delete all action_logs with nonexistent items or targets?')) {
                    $this->fail("Command canceled");
                }
            }
        }
        $map = [
            Accessory::class => 'accessories',
            Asset::class => 'assets',
            AssetModel::class => 'models',
            Component::class => 'components',
            Consumable::class => 'consumables',
            License::class => 'licenses',
            Location::class => 'locations',
            User::class => 'users',
        ];

        $rows = [];
        foreach (['item', 'target'] as $prefix) {
            foreach ($map as $class => $table) {
                $query = Actionlog::withTrashed()->where($prefix . '_type', $class)->whereNotIn($prefix . '_id', $class::select('id')->withTrashed());
                if ($this->option('delete')) {
                    $count = $query->delete();
                } elseif ($this->option('to-sql')) {
                    $count = $query->toRawSql();
                } else {
                    $count = $query->count();
                }
                $rows[] = [$prefix, $class, $table, $count];
                // DELETE FROM action_logs where {$prefix}_type='$class' /* make sure about backslashes! */ AND {$prefix}_id NOT IN (SELECT id FROM $table)
            }
        }
        if (!$this->option('delete')) {
            $this->line("Hint: use --delete to delete these entries instead of counting them");
            $this->newLine();
        }
        $this->table(['Attribute', 'Class', 'Table', 'Count'], $rows);
    }
}