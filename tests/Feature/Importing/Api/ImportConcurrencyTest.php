<?php

namespace Tests\Feature\Importing\Api;

use App\Models\Import;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\Importing\AssetsImportFileBuilder;
use Tests\Support\Importing\CleansUpImportFiles;

/**
 * Coverage for the per-import processing mutex on
 * Api\ImportController::process. The primitive is an atomic UPDATE against
 * imports.processing_by / processing_started_at with a two-branch WHERE:
 * unlocked (NULL) or 5-minute self-heal. Same-user overlapping requests
 * are intentionally blocked - the correct pattern is acquire-process-release,
 * with the next slice acquiring only after the previous slice released.
 */
class ImportConcurrencyTest extends ImportDataTestCase
{
    use CleansUpImportFiles;

    protected function importFileResponse(array $parameters = []): \Illuminate\Testing\TestResponse
    {
        if (! array_key_exists('import-type', $parameters)) {
            $parameters['import-type'] = 'asset';
        }

        return parent::importFileResponse($parameters);
    }

    #[Test]
    public function second_concurrent_caller_is_rejected_while_another_admin_holds_the_lock()
    {
        // Simulate admin A holding the mutex: another user_id is stamped
        // into the row and the timestamp is recent (well within the 5m
        // stale window).
        $adminA = User::factory()->superuser()->create();
        $adminB = User::factory()->superuser()->create();

        $file = AssetsImportFileBuilder::new();
        $import = Import::factory()->asset()->create(['file_path' => $file->saveToImportsDirectory()]);

        DB::table('imports')->where('id', $import->id)->update([
            'processing_by' => $adminA->id,
            'processing_started_at' => Carbon::now(),
        ]);

        $this->actingAsForApi($adminB);

        $response = $this->importFileResponse(['import' => $import->id]);

        $response->assertStatus(409);
        $response->assertJson([
            'status' => 'error',
            'messages' => trans('admin/hardware/message.import.already_processing'),
        ]);

        // Mutex owner and timestamp were NOT overwritten by admin B's attempt.
        $row = DB::table('imports')->where('id', $import->id)->first();
        $this->assertSame($adminA->id, (int) $row->processing_by);
    }

    #[Test]
    public function same_caller_is_also_rejected_while_their_own_prior_request_still_holds_the_lock()
    {
        // The customer-reported PedidosYa duplication was two full passes
        // through the AssetImporter by the same admin, one minute apart.
        // Whatever fired the second pass (browser retry, proxy retry,
        // wizard double-fire) presented as the SAME user. The mutex must
        // block it just as firmly as it blocks a second admin - otherwise
        // both passes race the app-layer unique-tag validation and both
        // insert.
        $admin = User::factory()->superuser()->create();

        $file = AssetsImportFileBuilder::new();
        $import = Import::factory()->asset()->create(['file_path' => $file->saveToImportsDirectory()]);

        DB::table('imports')->where('id', $import->id)->update([
            'processing_by' => $admin->id,
            'processing_started_at' => Carbon::now()->subSeconds(5),
        ]);

        $this->actingAsForApi($admin);

        $response = $this->importFileResponse(['import' => $import->id]);

        $response->assertStatus(409);
        $response->assertJson([
            'status' => 'error',
            'messages' => trans('admin/hardware/message.import.already_processing'),
        ]);
    }

    #[Test]
    public function lock_is_released_after_a_successful_process_so_the_next_slice_can_acquire()
    {
        // The wizard chains slices serially: slice N's ajax completes,
        // then slice N+1 fires. That only works if process() releases the
        // mutex before returning, so slice N+1 finds a NULL processing_by
        // to acquire against.
        $admin = User::factory()->superuser()->create();

        $file = AssetsImportFileBuilder::new();
        $import = Import::factory()->asset()->create(['file_path' => $file->saveToImportsDirectory()]);

        $this->actingAsForApi($admin);

        $response = $this->importFileResponse(['import' => $import->id]);

        $this->assertNotEquals(409, $response->status());

        // Lock was released on the way out.
        $row = DB::table('imports')->where('id', $import->id)->first();
        $this->assertNull($row->processing_by, 'Lock should have been released after the request finished.');
        $this->assertNull($row->processing_started_at, 'Lock timestamp should have been cleared after the request finished.');
    }

    #[Test]
    public function two_sequential_slices_from_the_same_admin_both_succeed()
    {
        // Regression for #19510: reporter hit "already processing" on the
        // second slice of a two-slice import even though nobody else was
        // touching the system. Simulate exactly that: same admin, two
        // sequential process() calls with offset/limit shaped like the
        // real wizard sends them.
        $admin = User::factory()->superuser()->create();

        $file = AssetsImportFileBuilder::times(3);
        $import = Import::factory()->asset()->create(['file_path' => $file->saveToImportsDirectory()]);

        $this->actingAsForApi($admin);

        $sliceOne = $this->importFileResponse([
            'import' => $import->id,
            'offset' => 0,
            'limit' => 2,
        ]);
        $this->assertNotEquals(409, $sliceOne->status(), 'First slice should not hit the mutex.');

        $sliceTwo = $this->importFileResponse([
            'import' => $import->id,
            'offset' => 2,
            'limit' => 2,
        ]);
        $this->assertNotEquals(409, $sliceTwo->status(), 'Second slice should not hit the mutex after the first slice released it.');

        $row = DB::table('imports')->where('id', $import->id)->first();
        $this->assertNull($row->processing_by, 'Lock should be clear after the second slice.');
    }

    #[Test]
    public function stale_lock_older_than_five_minutes_is_taken_over()
    {
        // A prior slice from admin A crashed mid-import, leaving
        // processing_by set but processing_started_at is now stale
        // (older than the 5m self-heal window). Admin B must be able
        // to acquire and proceed.
        $adminA = User::factory()->superuser()->create();
        $adminB = User::factory()->superuser()->create();

        $file = AssetsImportFileBuilder::new();
        $import = Import::factory()->asset()->create(['file_path' => $file->saveToImportsDirectory()]);

        DB::table('imports')->where('id', $import->id)->update([
            'processing_by' => $adminA->id,
            'processing_started_at' => Carbon::now()->subMinutes(10),
        ]);

        $this->actingAsForApi($adminB);

        $response = $this->importFileResponse(['import' => $import->id]);

        $this->assertNotEquals(409, $response->status(), 'A stale lock older than the self-heal window must not block a new caller.');

        // Stale-owner state got cleared. Ownership transitioned from
        // adminA (stale) -> adminB (acquired) -> NULL (released on the
        // way out). The important guarantee is that the stale entry is
        // no longer holding future callers off.
        $row = DB::table('imports')->where('id', $import->id)->first();
        $this->assertNull($row->processing_by, 'Stale lock should have been taken over and then released.');
        $this->assertNull($row->processing_started_at);
    }

    #[Test]
    public function fresh_import_with_no_prior_lock_holder_acquires_cleanly()
    {
        // Baseline: no lock at all, the process request acquires the
        // mutex, processes, and releases before responding.
        $admin = User::factory()->superuser()->create();

        $file = AssetsImportFileBuilder::new();
        $import = Import::factory()->asset()->create(['file_path' => $file->saveToImportsDirectory()]);

        // Sanity: no lock in place.
        $this->assertNull(DB::table('imports')->where('id', $import->id)->value('processing_by'));

        $this->actingAsForApi($admin);

        $response = $this->importFileResponse(['import' => $import->id]);

        $this->assertNotEquals(409, $response->status());

        // Lock released before returning (release-covered separately in
        // lock_is_released_after_a_successful_process; asserted here too
        // to catch regressions on the baseline path).
        $row = DB::table('imports')->where('id', $import->id)->first();
        $this->assertNull($row->processing_by);
        $this->assertNull($row->processing_started_at);
    }
}
