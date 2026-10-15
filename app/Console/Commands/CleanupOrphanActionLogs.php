<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\info;
use function Laravel\Prompts\note;
use function Laravel\Prompts\progress;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\table;
use function Laravel\Prompts\warning;

/**
 * Find (and optionally delete) action_log rows whose polymorphic parent
 * no longer exists.
 *
 * Prior versions of snipeit:purge left orphaned action_logs behind when
 * they force-deleted parent rows without cleaning up the polymorphic
 * children. On installations with millions of action_log rows this can
 * accumulate over years.
 *
 * Scans both column pairs on action_logs:
 *   - (item_type, item_id)     — polymorphic subject
 *   - (target_type, target_id) — polymorphic recipient
 *
 * "Orphan" here means: type is a class we can resolve to a table, and
 * the id does not exist in that table. Rows where the class cannot be
 * resolved (renamed / removed model) are reported separately and NOT
 * deleted unless --include-unresolvable is passed. Rows with a
 * type-without-id or id-without-type are reported as "malformed" and are
 * out of scope for deletion by this command.
 */
class CleanupOrphanActionLogs extends Command
{
    protected $signature = 'snipeit:orphan-action-logs
        {--delete : Actually delete the orphans. Default is dry-run.}
        {--chunk=1000 : Rows deleted per batch. Larger = fewer round trips, longer lock hold.}
        {--include-unresolvable : Also delete rows whose type is a class that no longer exists in the codebase.}';

    protected $description = 'Find (and optionally delete) action_log rows whose polymorphic parent no longer exists. Cleanup for orphans left behind by older snipeit:purge runs.';

    /**
     * Column pairs on action_logs that reference a polymorphic parent.
     * Each pair is (type_column, id_column) and we scan both.
     */
    private const POLYMORPHIC_PAIRS = [
        ['type' => 'item_type', 'id' => 'item_id'],
        ['type' => 'target_type', 'id' => 'target_id'],
    ];

    public function handle(): int
    {
        $delete = (bool) $this->option('delete');
        $chunk = max(100, (int) $this->option('chunk'));
        $includeUnresolvable = (bool) $this->option('include-unresolvable');

        info(sprintf('Scanning %s action_log rows...',
            number_format(DB::table('action_logs')->count())
        ));

        // Cache of type → table (or null if unresolvable) so we only do
        // the class-resolve dance once per distinct type value.
        $resolved = [];
        $resolve = function (string $type) use (&$resolved): ?string {
            if (! array_key_exists($type, $resolved)) {
                $resolved[$type] = $this->resolveTable($type);
            }

            return $resolved[$type];
        };

        // Per-pair scan. For each (type, id) column pair, group the table
        // by type, then for each type count how many rows point at a
        // nonexistent parent.
        $orphans = [];
        $unresolvable = [];
        foreach (self::POLYMORPHIC_PAIRS as $pair) {
            $types = spin(
                fn () => $this->distinctTypes($pair['type']),
                "Reading distinct {$pair['type']} values..."
            );

            foreach ($types as $type) {
                $table = $resolve($type);
                if ($table === null) {
                    $count = DB::table('action_logs')->where($pair['type'], $type)->count();
                    if ($count > 0) {
                        $unresolvable[] = [
                            'pair' => $pair,
                            'type' => $type,
                            'count' => $count,
                        ];
                    }

                    continue;
                }

                $count = spin(
                    fn () => DB::table('action_logs')
                        ->where($pair['type'], $type)
                        ->whereNotExists(fn ($q) => $q->from($table)
                            ->whereColumn($table.'.id', 'action_logs.'.$pair['id']))
                        ->count(),
                    "Counting orphans for {$pair['type']}={$type}..."
                );

                if ($count > 0) {
                    $orphans[] = [
                        'pair' => $pair,
                        'type' => $type,
                        'table' => $table,
                        'count' => $count,
                    ];
                }
            }
        }

        $malformed = $this->countMalformed();

        // Report before any destructive action.
        $summaryRows = [];
        foreach ($orphans as $o) {
            $summaryRows[] = [
                $o['pair']['type'].' → '.$o['pair']['id'],
                $o['type'],
                $o['table'],
                number_format($o['count']),
                'orphan',
            ];
        }
        foreach ($unresolvable as $u) {
            $summaryRows[] = [
                $u['pair']['type'].' → '.$u['pair']['id'],
                $u['type'],
                '(class not found)',
                number_format($u['count']),
                'unresolvable',
            ];
        }
        foreach ($malformed as $m) {
            $summaryRows[] = [
                $m['label'],
                '—',
                '—',
                number_format($m['count']),
                'malformed',
            ];
        }

        if (empty($summaryRows)) {
            info('No orphaned, unresolvable, or malformed action_logs found. Table is clean.');

            return self::SUCCESS;
        }

        table(['Column pair', 'Type', 'Parent table', 'Rows', 'Category'], $summaryRows);

        $orphanTotal = array_sum(array_column($orphans, 'count'));
        $unresolvableTotal = array_sum(array_column($unresolvable, 'count'));
        $malformedTotal = array_sum(array_column($malformed, 'count'));

        note(sprintf(
            'Totals: %s orphans, %s unresolvable, %s malformed.',
            number_format($orphanTotal),
            number_format($unresolvableTotal),
            number_format($malformedTotal)
        ));

        if ($malformedTotal > 0) {
            warning('Malformed rows (type-without-id or id-without-type) are reported for triage but never deleted by this command. Investigate the app code that wrote them.');
        }

        if (! $delete) {
            note('Dry run. Pass --delete to actually remove orphaned rows.'
                .($unresolvableTotal > 0 ? ' Add --include-unresolvable to also remove rows whose class no longer exists.' : ''));

            return self::SUCCESS;
        }

        $toDelete = $orphanTotal + ($includeUnresolvable ? $unresolvableTotal : 0);
        if ($toDelete === 0) {
            info('Nothing to delete.');

            return self::SUCCESS;
        }

        warning(sprintf('About to delete %s action_log rows. This cannot be undone.', number_format($toDelete)));
        if (! confirm('Proceed with deletion?', default: false)) {
            info('Cancelled. Nothing was deleted.');

            return self::SUCCESS;
        }

        $started = microtime(true);
        $deletedTotal = 0;

        foreach ($orphans as $o) {
            $deletedTotal += $this->deleteOrphans(
                $o['pair'],
                $o['type'],
                $o['table'],
                $o['count'],
                $chunk
            );
        }

        if ($includeUnresolvable) {
            foreach ($unresolvable as $u) {
                $deletedTotal += $this->deleteUnresolvable(
                    $u['pair'],
                    $u['type'],
                    $u['count'],
                    $chunk
                );
            }
        }

        info(sprintf('Deleted %s rows in %.2fs.',
            number_format($deletedTotal),
            microtime(true) - $started
        ));

        return self::SUCCESS;
    }

    /**
     * Distinct values in one polymorphic type column. On a table with a
     * composite index starting with the type column, this uses a loose
     * index scan and stays fast even at scale.
     */
    private function distinctTypes(string $column): Collection
    {
        return DB::table('action_logs')
            ->whereNotNull($column)
            ->where($column, '!=', '')
            ->distinct()
            ->pluck($column);
    }

    /**
     * Map a stored polymorphic type (usually an FQCN like
     * "App\Models\Asset") to its underlying table name. Returns null if
     * the class no longer exists, is not an Eloquent model, or fails to
     * instantiate — those are the "unresolvable" case.
     */
    private function resolveTable(string $className): ?string
    {
        if (! class_exists($className)) {
            return null;
        }
        try {
            $instance = new $className;
        } catch (Throwable) {
            return null;
        }
        if (! $instance instanceof Model) {
            return null;
        }

        return $instance->getTable();
    }

    /**
     * Count rows that violate the "both type-columns and id-column set,
     * or both null" invariant. Malformed rows are surfaced for operator
     * triage, not deleted, because they usually indicate an app-side bug
     * that would keep re-creating them.
     *
     * @return list<array{label: string, count: int}>
     */
    private function countMalformed(): array
    {
        $out = [];
        foreach (self::POLYMORPHIC_PAIRS as $pair) {
            $typeButNoId = DB::table('action_logs')
                ->whereNotNull($pair['type'])
                ->where($pair['type'], '!=', '')
                ->whereNull($pair['id'])
                ->count();
            if ($typeButNoId > 0) {
                $out[] = [
                    'label' => "{$pair['type']} set, {$pair['id']} NULL",
                    'count' => $typeButNoId,
                ];
            }

            $idButNoType = DB::table('action_logs')
                ->whereNotNull($pair['id'])
                ->where(function ($q) use ($pair) {
                    $q->whereNull($pair['type'])->orWhere($pair['type'], '');
                })
                ->count();
            if ($idButNoType > 0) {
                $out[] = [
                    'label' => "{$pair['id']} set, {$pair['type']} NULL",
                    'count' => $idButNoType,
                ];
            }
        }

        return $out;
    }

    /**
     * Delete orphans for one (column pair, type, table) triple in chunks.
     * Fetch ids first, delete by primary key. This keeps each DELETE
     * small (bounded by the chunk size) and gives the progress bar
     * meaningful ticks, at the cost of two queries per chunk.
     */
    private function deleteOrphans(array $pair, string $type, string $table, int $expected, int $chunk): int
    {
        $deleted = 0;
        $progress = progress(
            label: "Deleting orphans: {$pair['type']}={$type}",
            steps: $expected
        );
        $progress->start();

        while (true) {
            $ids = DB::table('action_logs')
                ->where($pair['type'], $type)
                ->whereNotExists(fn ($q) => $q->from($table)
                    ->whereColumn($table.'.id', 'action_logs.'.$pair['id']))
                ->limit($chunk)
                ->pluck('id');

            if ($ids->isEmpty()) {
                break;
            }

            $n = DB::table('action_logs')->whereIn('id', $ids)->delete();
            $deleted += $n;
            $progress->advance($n);
        }

        $progress->finish();

        return $deleted;
    }

    /**
     * Same chunked pattern for unresolvable-class rows: every row for that
     * type is by definition orphaned, so no NOT EXISTS check is needed.
     */
    private function deleteUnresolvable(array $pair, string $type, int $expected, int $chunk): int
    {
        $deleted = 0;
        $progress = progress(
            label: "Deleting unresolvable: {$pair['type']}={$type}",
            steps: $expected
        );
        $progress->start();

        while (true) {
            $ids = DB::table('action_logs')
                ->where($pair['type'], $type)
                ->limit($chunk)
                ->pluck('id');

            if ($ids->isEmpty()) {
                break;
            }

            $n = DB::table('action_logs')->whereIn('id', $ids)->delete();
            $deleted += $n;
            $progress->advance($n);
        }

        $progress->finish();

        return $deleted;
    }
}
