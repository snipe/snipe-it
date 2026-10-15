<?php

namespace Tests\Feature\Console\Commands;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CleanupOrphanActionLogsTest extends TestCase
{
    public function test_dry_run_reports_orphans_without_deleting(): void
    {
        // Non-orphan: parent asset exists.
        $liveAsset = Asset::factory()->create();
        $liveLog = Actionlog::factory()->create([
            'item_type' => Asset::class,
            'item_id' => $liveAsset->id,
            'action_type' => 'checkout',
        ]);

        // Orphan: item_id points at an asset that doesn't exist.
        $orphanLog = Actionlog::factory()->create([
            'item_type' => Asset::class,
            'item_id' => 999999,
            'action_type' => 'checkout',
        ]);

        $this->artisan('snipeit:orphan-action-logs')->assertExitCode(0);

        // Nothing deleted in dry-run.
        $this->assertDatabaseHas('action_logs', ['id' => $liveLog->id]);
        $this->assertDatabaseHas('action_logs', ['id' => $orphanLog->id]);
    }

    public function test_delete_flag_removes_orphaned_rows_and_preserves_live_ones(): void
    {
        $liveAsset = Asset::factory()->create();
        $liveLog = Actionlog::factory()->create([
            'item_type' => Asset::class,
            'item_id' => $liveAsset->id,
            'action_type' => 'checkout',
        ]);

        $orphanLog = Actionlog::factory()->create([
            'item_type' => Asset::class,
            'item_id' => 999999,
            'action_type' => 'checkout',
        ]);

        $this->artisan('snipeit:orphan-action-logs', ['--delete' => true])
            ->expectsConfirmation('Proceed with deletion?', 'yes')
            ->assertExitCode(0);

        $this->assertDatabaseHas('action_logs', ['id' => $liveLog->id]);
        $this->assertDatabaseMissing('action_logs', ['id' => $orphanLog->id]);
    }

    public function test_polymorphic_collision_across_item_types_does_not_flag_valid_rows(): void
    {
        // Two rows in different tables can share the same id (auto-increment
        // per table). An action_log with item_type=User and item_id=X must
        // not be flagged as orphan just because id=X also exists in the
        // assets table. Scan-only run — no orphans exist, so no prompt.
        $asset = Asset::factory()->create();
        $user = User::factory()->create();

        $assetLog = Actionlog::factory()->create([
            'item_type' => Asset::class,
            'item_id' => $asset->id,
            'action_type' => 'checkout',
        ]);
        $userLog = Actionlog::factory()->create([
            'item_type' => User::class,
            'item_id' => $user->id,
            'action_type' => 'update',
        ]);

        $this->artisan('snipeit:orphan-action-logs', ['--delete' => true])
            ->assertExitCode(0);

        $this->assertDatabaseHas('action_logs', ['id' => $assetLog->id]);
        $this->assertDatabaseHas('action_logs', ['id' => $userLog->id]);
    }

    public function test_confirmation_declined_does_not_delete(): void
    {
        Actionlog::factory()->create([
            'item_type' => Asset::class,
            'item_id' => 999999,
            'action_type' => 'checkout',
        ]);

        $orphanCountBefore = DB::table('action_logs')->count();

        $this->artisan('snipeit:orphan-action-logs', ['--delete' => true])
            ->expectsConfirmation('Proceed with deletion?', 'no')
            ->assertExitCode(0);

        $this->assertEquals($orphanCountBefore, DB::table('action_logs')->count());
    }

    public function test_unresolvable_type_reported_but_not_deleted_by_default(): void
    {
        // A row whose item_type is a class that no longer exists. Reported
        // as unresolvable, preserved unless --include-unresolvable. Without
        // that flag and with no other orphans present, there's nothing to
        // delete, so no confirmation prompt fires.
        $ghostLog = Actionlog::factory()->create([
            'item_type' => 'App\\Models\\ThisClassDoesNotExist',
            'item_id' => 1,
            'action_type' => 'update',
        ]);

        $this->artisan('snipeit:orphan-action-logs', ['--delete' => true])
            ->assertExitCode(0);

        $this->assertDatabaseHas('action_logs', ['id' => $ghostLog->id]);
    }

    public function test_include_unresolvable_flag_deletes_ghost_class_rows(): void
    {
        $ghostLog = Actionlog::factory()->create([
            'item_type' => 'App\\Models\\ThisClassDoesNotExist',
            'item_id' => 1,
            'action_type' => 'update',
        ]);

        $this->artisan('snipeit:orphan-action-logs', [
            '--delete' => true,
            '--include-unresolvable' => true,
        ])
            ->expectsConfirmation('Proceed with deletion?', 'yes')
            ->assertExitCode(0);

        $this->assertDatabaseMissing('action_logs', ['id' => $ghostLog->id]);
    }

    public function test_orphans_on_target_columns_are_also_cleaned(): void
    {
        // The command must scan BOTH (item_type, item_id) AND
        // (target_type, target_id). A row that is valid on the item_* side
        // but orphaned on the target_* side should still be caught, since
        // User::userlog() and similar relations read target_id/target_type.
        // (item_type is NOT NULL in the schema, so we set it to a valid
        // parent to isolate the target-side orphan being the reason for
        // deletion.)
        $liveAsset = Asset::factory()->create();
        $orphanTargetLog = Actionlog::factory()->create([
            'item_type' => Asset::class,
            'item_id' => $liveAsset->id,
            'target_type' => User::class,
            'target_id' => 999999,
            'action_type' => 'update',
        ]);

        $this->artisan('snipeit:orphan-action-logs', ['--delete' => true])
            ->expectsConfirmation('Proceed with deletion?', 'yes')
            ->assertExitCode(0);

        $this->assertDatabaseMissing('action_logs', ['id' => $orphanTargetLog->id]);
    }

    public function test_clean_table_reports_nothing(): void
    {
        $asset = Asset::factory()->create();
        Actionlog::factory()->create([
            'item_type' => Asset::class,
            'item_id' => $asset->id,
            'action_type' => 'checkout',
        ]);

        $this->artisan('snipeit:orphan-action-logs')
            ->expectsOutputToContain('Table is clean')
            ->assertExitCode(0);
    }
}
