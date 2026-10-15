<?php

namespace App\Console\Commands;

use App\Enums\ActionType;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\CompanyableScope;
use App\Models\Maintenance;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Merges duplicate assets that share the same asset_tag. Written for
 * installs that hit the pre-mutex asset importer bug where a bad
 * re-import could create ghost duplicates with no real data of their
 * own. asset_tag is globally unique (`unique_undeleted:assets,asset_tag`)
 * so we group by asset_tag alone and do not scope by company_id.
 *
 * Winner rule per cluster:
 *   1. Count how many duplicates in the cluster have any real data
 *      (any Maintenance referencing the asset, or any action_log
 *      referencing the asset with a non-null filename).
 *   2. If exactly one has data, keep that one.
 *   3. If none do, keep the newest by primary key.
 *   4. If more than one has data, skip the cluster entirely and flag
 *      it for manual review. Do not guess.
 *   5. If the cluster's rows span more than one company_id, skip it
 *      too. Cross-company merges would break tenant isolation and are
 *      not expected in the importer-bug scenario this command targets.
 *
 * For processed clusters, the loser's user-interaction action_logs
 * (checkouts, checkins, audits, notes, file uploads, requests) get
 * re-parented to the winner, then losers are soft-deleted. Self-
 * lifecycle log rows (create, update, delete, restore) that describe
 * the loser's own record lifecycle are left with the deleted loser
 * rather than migrated, since re-parenting them would give the
 * winner phantom duplicate "created" or "updated" events. Losers
 * with data (the ambiguous-cluster case) are never touched.
 *
 * Runs in a transaction so a mid-run failure rolls back cleanly. Use
 * --dry-run to print the plan without modifying anything.
 */
class DedupeAssets extends Command
{
    protected $signature = 'snipeit:dedupe-assets
                            {--dry-run : Print the plan without modifying data}';

    protected $description = 'Merges duplicate assets by asset_tag and re-parents their action_logs to the survivor.';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');

        if ($dryRun) {
            $this->info('DRY RUN — no changes will be written.');
        }

        $clusters = $this->findClusters();

        if ($clusters->isEmpty()) {
            $this->info('No duplicate asset tags found.');

            return self::SUCCESS;
        }

        $rows = [];
        $merged = 0;
        $losersRemoved = 0;
        $logsMigrated = 0;
        $skipped = 0;

        $lifecycleTypes = array_map(fn (ActionType $type) => $type->value, [
            ActionType::Create,
            ActionType::Update,
            ActionType::Delete,
            ActionType::Restore,
        ]);

        DB::transaction(function () use ($clusters, $dryRun, $lifecycleTypes, &$rows, &$merged, &$losersRemoved, &$logsMigrated, &$skipped) {
            foreach ($clusters as $cluster) {
                $decision = $this->planCluster($cluster);

                $row = [
                    'asset_tag' => $cluster->first()->asset_tag,
                    'company_id' => $cluster->pluck('company_id')->unique()->implode(', '),
                ];

                if ($decision['status'] !== 'merge') {
                    $row['winner_id'] = '—';
                    $row['loser_ids'] = $cluster->pluck('id')->implode(', ');
                    $row['action_logs'] = 0;
                    $row['status'] = 'skipped ('.$decision['reason'].')';

                    $skipped++;
                    $rows[] = $row;

                    continue;
                }

                $winner = $decision['winner'];
                $losers = $decision['losers'];
                $loserIds = $losers->pluck('id')->all();

                $logsForLosers = Actionlog::where('item_type', Asset::class)
                    ->whereIn('item_id', $loserIds)
                    ->whereNotIn('action_type', $lifecycleTypes)
                    ->count();

                $row['winner_id'] = $winner->id;
                $row['loser_ids'] = implode(', ', $loserIds);
                $row['action_logs'] = $logsForLosers;
                $row['status'] = $dryRun ? 'would merge' : 'merged';

                if (! $dryRun) {
                    Actionlog::where('item_type', Asset::class)
                        ->whereIn('item_id', $loserIds)
                        ->whereNotIn('action_type', $lifecycleTypes)
                        ->update(['item_id' => $winner->id]);

                    Asset::withoutGlobalScope(CompanyableScope::class)
                        ->whereIn('id', $loserIds)
                        ->delete();
                }

                $merged++;
                $losersRemoved += count($loserIds);
                $logsMigrated += $logsForLosers;

                $rows[] = $row;
            }
        });

        $this->table(
            ['Asset Tag', 'Company ID(s)', 'Winner ID', 'Loser IDs', 'Action Logs', 'Status'],
            $rows,
        );

        $verb = $dryRun ? 'Would remove' : 'Removed';
        $this->info(sprintf(
            '%d cluster(s) processed, %d skipped. %s %d loser(s), migrating %d action log(s).',
            $merged,
            $skipped,
            $verb,
            $losersRemoved,
            $logsMigrated,
        ));

        return self::SUCCESS;
    }

    /**
     * @return Collection<int, EloquentCollection<int, Asset>>
     */
    protected function findClusters(): Collection
    {
        $dupeTags = Asset::withoutGlobalScope(CompanyableScope::class)
            ->select('asset_tag')
            ->selectRaw('COUNT(*) as dupe_count')
            ->groupBy('asset_tag')
            ->having('dupe_count', '>', 1)
            ->pluck('asset_tag');

        $clusters = new Collection;

        foreach ($dupeTags as $tag) {
            $clusters->push(
                Asset::withoutGlobalScope(CompanyableScope::class)
                    ->where('asset_tag', $tag)
                    ->orderByDesc('id')
                    ->get()
            );
        }

        return $clusters;
    }

    /**
     * Decide the winner (or skip) for one cluster.
     *
     * @param  EloquentCollection<int, Asset>  $cluster
     * @return array{status: 'merge'|'skipped', reason?: string, winner?: Asset, losers?: EloquentCollection<int, Asset>}
     */
    protected function planCluster(EloquentCollection $cluster): array
    {
        if ($cluster->pluck('company_id')->unique()->count() > 1) {
            return ['status' => 'skipped', 'reason' => 'spans multiple companies'];
        }

        $withData = $cluster->filter(fn (Asset $asset) => $this->hasRealData($asset));

        if ($withData->count() > 1) {
            return ['status' => 'skipped', 'reason' => 'multiple have data'];
        }

        $winner = $withData->count() === 1
            ? $withData->first()
            : $cluster->sortByDesc('id')->first();

        $losers = $cluster->reject(fn (Asset $asset) => $asset->id === $winner->id)->values();

        return [
            'status' => 'merge',
            'winner' => $winner,
            'losers' => $losers,
        ];
    }

    /**
     * Any Maintenance referencing the asset, or any action_log with a
     * non-null filename referencing the asset. Filename covers both
     * the Files tab uploads and checkin/checkout notes with
     * attachments — both go through the action_log filename column.
     */
    protected function hasRealData(Asset $asset): bool
    {
        $hasMaintenance = Maintenance::where('item_type', Asset::class)
            ->where('item_id', $asset->id)
            ->exists();

        if ($hasMaintenance) {
            return true;
        }

        return Actionlog::where('item_type', Asset::class)
            ->where('item_id', $asset->id)
            ->whereNotNull('filename')
            ->where('filename', '!=', '')
            ->exists();
    }
}
