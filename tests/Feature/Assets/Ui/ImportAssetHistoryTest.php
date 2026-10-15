<?php

namespace Tests\Feature\Assets\Ui;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Import;
use App\Models\Location;
use App\Models\User;
use Tests\Support\Importing\AssetHistoryImportFileBuilder;
use Tests\Support\Importing\CleansUpImportFiles;
use Tests\TestCase;

class ImportAssetHistoryTest extends TestCase
{
    use CleansUpImportFiles;

    public function test_legacy_get_history_route_redirects_to_importer(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/hardware/history')
            ->assertRedirect(route('imports.index'));
    }

    public function test_legacy_post_history_endpoint_is_gone(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->post('/hardware/history')
            ->assertStatus(405);
    }

    public function test_process_endpoint_blocked_in_demo_mode_for_non_superadmin(): void
    {
        // Uploads are blocked at Api\ImportController::store, and non-
        // superadmins are also blocked from processing so they can't
        // mutate the demo DB via any leftover Import row. Superadmins
        // are allowed through so they can exercise the seeded demo
        // samples end to end (see companion test below).
        config(['app.lock_passwords' => true]);

        $actor = User::factory()->canImport()->create();
        $import = Import::factory()->assetHistory()->create(['created_by' => $actor->id]);

        $this->actingAsForApi($actor);
        $this->postJson(
            route('api.imports.importFile', ['import' => $import->id]),
            ['import-type' => 'assetHistory', 'import' => $import->id],
        )->assertStatus(422);
    }

    public function test_process_endpoint_allowed_in_demo_mode_for_superadmin(): void
    {
        // Superadmins bypass the demo-mode gate on process() so the
        // seeded sample CSVs (populated by snipeit:demo-settings) can
        // actually be run against the demo DB. Without a real CSV on
        // disk the import will error out below the gate, so this test
        // just proves the gate itself lets the superadmin through
        // (any status other than 422 "feature disabled" is fine).
        config(['app.lock_passwords' => true]);

        $actor = User::factory()->canImport()->superuser()->create();
        $import = Import::factory()->assetHistory()->create(['created_by' => $actor->id]);

        $this->actingAsForApi($actor);
        $response = $this->postJson(
            route('api.imports.importFile', ['import' => $import->id]),
            ['import-type' => 'assetHistory', 'import' => $import->id],
        );

        $this->assertNotEquals(
            trans('general.feature_disabled'),
            $response->json('messages'),
            'Superadmin should not hit the demo-mode gate on process().',
        );
    }

    public function test_asset_history_import_requires_import_permission(): void
    {
        $actor = User::factory()->create();
        $import = Import::factory()->assetHistory()->create(['created_by' => $actor->id]);

        $this->actingAsForApi($actor);
        $this->postJson(
            route('api.imports.importFile', ['import' => $import->id]),
            ['import-type' => 'assetHistory', 'import' => $import->id],
        )->assertForbidden();
    }

    public function test_asset_history_import_creates_actionlogs_and_assigns_user(): void
    {
        $actor = User::factory()->canImport()->create();
        $target = User::factory()->create(['username' => 'target.user']);
        $asset = Asset::factory()->create([
            'asset_tag' => 'AHIST-1',
            'assigned_to' => null,
            'assigned_type' => null,
        ]);

        $checkoutDate = now()->subDay()->format('Y-m-d H:i:s');
        $checkinDate = now()->addDays(30)->format('Y-m-d H:i:s');

        $file = AssetHistoryImportFileBuilder::new([
            'assetTag' => $asset->asset_tag,
            'name' => $target->username,
            'email' => '',
            'checkoutDate' => $checkoutDate,
            'checkinDate' => $checkinDate,
        ]);

        $import = Import::factory()->assetHistory()->create([
            'created_by' => $actor->id,
            'file_path' => $file->saveToImportsDirectory(),
        ]);

        $this->actingAsForApi($actor);
        $this->postJson(
            route('api.imports.importFile', ['import' => $import->id]),
            [
                'import-type' => 'assetHistory',
                'import' => $import->id,
                'match_username' => true,
            ],
        )->assertOk();

        $asset->refresh();
        $this->assertEquals($target->id, $asset->assigned_to);
        $this->assertEquals(User::class, $asset->assigned_type);

        $this->assertDatabaseHas('action_logs', [
            'item_id' => $asset->id,
            'item_type' => Asset::class,
            'target_id' => $target->id,
            'target_type' => User::class,
            'action_type' => 'checkout',
        ]);

        $this->assertDatabaseHas('action_logs', [
            'item_id' => $asset->id,
            'item_type' => Asset::class,
            'target_id' => null,
            'action_type' => 'checkin',
        ]);
    }

    public function test_asset_history_import_does_not_reassign_when_checkin_is_past(): void
    {
        $actor = User::factory()->canImport()->create();
        $target = User::factory()->create(['username' => 'past.user']);
        $asset = Asset::factory()->create([
            'asset_tag' => 'AHIST-2',
            'assigned_to' => null,
            'assigned_type' => null,
        ]);

        $file = AssetHistoryImportFileBuilder::new([
            'assetTag' => $asset->asset_tag,
            'name' => $target->username,
            'email' => '',
            'checkoutDate' => now()->subDays(30)->format('Y-m-d H:i:s'),
            'checkinDate' => now()->subDays(15)->format('Y-m-d H:i:s'),
        ]);

        $import = Import::factory()->assetHistory()->create([
            'created_by' => $actor->id,
            'file_path' => $file->saveToImportsDirectory(),
        ]);

        $this->actingAsForApi($actor);
        $this->postJson(
            route('api.imports.importFile', ['import' => $import->id]),
            [
                'import-type' => 'assetHistory',
                'import' => $import->id,
                'match_username' => true,
            ],
        )->assertOk();

        $asset->refresh();
        $this->assertNull($asset->assigned_to);
        $this->assertNull($asset->assigned_type);

        // Historical checkout + checkin actionlogs both got written even
        // though the asset ends up in a checked-in state.
        $this->assertDatabaseHas('action_logs', [
            'item_id' => $asset->id,
            'action_type' => 'checkout',
        ]);
        $this->assertDatabaseHas('action_logs', [
            'item_id' => $asset->id,
            'action_type' => 'checkin',
        ]);
    }

    public function test_asset_history_import_skips_unknown_asset_tag(): void
    {
        $actor = User::factory()->canImport()->create();
        User::factory()->create(['username' => 'someone']);

        $file = AssetHistoryImportFileBuilder::new([
            'assetTag' => 'DOES-NOT-EXIST',
            'name' => 'someone',
            'email' => '',
            'checkoutDate' => now()->format('Y-m-d H:i:s'),
            'checkinDate' => '',
        ]);

        $import = Import::factory()->assetHistory()->create([
            'created_by' => $actor->id,
            'file_path' => $file->saveToImportsDirectory(),
        ]);

        $this->actingAsForApi($actor);
        // Skipped rows now surface as import-errors so the wizard can
        // display the reason (Asset does not exist) instead of hiding it
        // in laravel.log. The 500 status is the shared API contract for
        // an errors-non-empty return.
        $response = $this->postJson(
            route('api.imports.importFile', ['import' => $import->id]),
            ['import-type' => 'assetHistory', 'import' => $import->id, 'match_username' => true],
        );
        $response->assertStatus(500);
        $this->assertEquals('import-errors', $response->json('status'));
        $this->assertArrayHasKey('Asset DOES-NOT-EXIST', $response->json('messages'));

        $this->assertSame(0, Actionlog::where('note', 'like', '%history importer%')->count());
    }

    public function test_asset_history_import_skips_row_when_user_not_matched(): void
    {
        $actor = User::factory()->canImport()->create();
        $asset = Asset::factory()->create([
            'asset_tag' => 'AHIST-3',
            'assigned_to' => null,
            'assigned_type' => null,
        ]);

        $file = AssetHistoryImportFileBuilder::new([
            'assetTag' => $asset->asset_tag,
            'name' => 'no.such.user',
            'email' => '',
            'checkoutDate' => now()->format('Y-m-d H:i:s'),
            'checkinDate' => '',
        ]);

        $import = Import::factory()->assetHistory()->create([
            'created_by' => $actor->id,
            'file_path' => $file->saveToImportsDirectory(),
        ]);

        $this->actingAsForApi($actor);
        $response = $this->postJson(
            route('api.imports.importFile', ['import' => $import->id]),
            ['import-type' => 'assetHistory', 'import' => $import->id, 'match_username' => true],
        );
        $response->assertStatus(500);
        $this->assertEquals('import-errors', $response->json('status'));
        $this->assertArrayHasKey('Asset '.$asset->asset_tag, $response->json('messages'));

        $asset->refresh();
        $this->assertNull($asset->assigned_to);
        $this->assertDatabaseMissing('action_logs', [
            'item_id' => $asset->id,
            'action_type' => 'checkout',
        ]);
    }

    public function test_asset_history_import_checks_out_to_location_when_target_type_is_location(): void
    {
        // Ensures the resulting state is
        // the same shape Snipe-IT itself would produce via a UI checkout.
        $actor = User::factory()->canImport()->create();
        $location = Location::factory()->create(['name' => 'Fundo Chao']);
        $asset = Asset::factory()->create([
            'asset_tag' => 'AHIST-LOC-1',
            'assigned_to' => null,
            'assigned_type' => null,
        ]);

        $file = AssetHistoryImportFileBuilder::new([
            'assetTag' => $asset->asset_tag,
            'name' => $location->name,
            'email' => '',
            'checkoutDate' => now()->subDay()->format('Y-m-d H:i:s'),
            'checkinDate' => now()->addDays(30)->format('Y-m-d H:i:s'),
            'targetType' => 'location',
        ]);

        $import = Import::factory()->assetHistory()->create([
            'created_by' => $actor->id,
            'file_path' => $file->saveToImportsDirectory(),
        ]);

        $this->actingAsForApi($actor);
        $this->postJson(
            route('api.imports.importFile', ['import' => $import->id]),
            ['import-type' => 'assetHistory', 'import' => $import->id],
        )->assertOk();

        $asset->refresh();
        $this->assertEquals($location->id, $asset->assigned_to);
        $this->assertEquals(Location::class, $asset->assigned_type);
        $this->assertEquals(
            $location->id,
            $asset->location_id,
            'When checked out to a Location, the asset\'s own location_id must mirror the target so the hardware list places it correctly.'
        );

        $this->assertDatabaseHas('action_logs', [
            'item_id' => $asset->id,
            'item_type' => Asset::class,
            'target_id' => $location->id,
            'target_type' => Location::class,
            'action_type' => 'checkout',
        ]);
    }

    public function test_asset_history_import_falls_back_to_user_lookup_when_target_type_absent(): void
    {
        // Backwards-compat with pre-target-type CSVs: Name should still
        // resolve as a user when the CSV has no target_type column.
        $actor = User::factory()->canImport()->create();
        $target = User::factory()->create(['username' => 'legacy.compat.user']);
        $asset = Asset::factory()->create([
            'asset_tag' => 'AHIST-LEGACY-1',
            'assigned_to' => null,
            'assigned_type' => null,
        ]);

        $file = AssetHistoryImportFileBuilder::new([
            'assetTag' => $asset->asset_tag,
            'name' => $target->username,
            'email' => '',
            'checkoutDate' => now()->format('Y-m-d H:i:s'),
            'checkinDate' => now()->addDays(7)->format('Y-m-d H:i:s'),
            // targetType intentionally omitted from the CSV.
        ]);
        $file->forget('targetType');

        $import = Import::factory()->assetHistory()->create([
            'created_by' => $actor->id,
            'file_path' => $file->saveToImportsDirectory(),
        ]);

        $this->actingAsForApi($actor);
        $this->postJson(
            route('api.imports.importFile', ['import' => $import->id]),
            [
                'import-type' => 'assetHistory',
                'import' => $import->id,
                'match_username' => true,
            ],
        )->assertOk();

        $asset->refresh();
        $this->assertEquals($target->id, $asset->assigned_to);
        $this->assertEquals(User::class, $asset->assigned_type);
    }

    public function test_asset_history_import_stamps_csv_note_onto_checkout_actionlog(): void
    {
        // Legacy systems commonly carry a per-checkout narrative that
        // needs to migrate through ("student damaged screen",
        // "shipped to remote site"). CSV Notes column value takes over
        // the actionlog note field so that context lands with the row.
        $actor = User::factory()->canImport()->create();
        $target = User::factory()->create(['username' => 'note.receiver']);
        $asset = Asset::factory()->create([
            'asset_tag' => 'AHIST-NOTE-1',
            'assigned_to' => null,
            'assigned_type' => null,
        ]);

        $file = AssetHistoryImportFileBuilder::new([
            'assetTag' => $asset->asset_tag,
            'name' => $target->username,
            'email' => '',
            'checkoutDate' => now()->subDay()->format('Y-m-d H:i:s'),
            'checkinDate' => now()->addDays(7)->format('Y-m-d H:i:s'),
            'notes' => 'Damaged screen on return',
        ]);

        $import = Import::factory()->assetHistory()->create([
            'created_by' => $actor->id,
            'file_path' => $file->saveToImportsDirectory(),
        ]);

        $this->actingAsForApi($actor);
        $this->postJson(
            route('api.imports.importFile', ['import' => $import->id]),
            ['import-type' => 'assetHistory', 'import' => $import->id, 'match_username' => true],
        )->assertOk();

        $this->assertDatabaseHas('action_logs', [
            'item_id' => $asset->id,
            'target_id' => $target->id,
            'action_type' => 'checkout',
            'note' => 'Damaged screen on return',
        ]);
    }

    public function test_asset_history_import_keeps_default_note_when_csv_note_is_absent(): void
    {
        // Regression guard for the "blank / absent falls back" branch:
        // when the CSV doesn't include a Notes column at all, the
        // actionlog still gets the auto-generated "imported by X from
        // history importer" line so the audit trail records how the
        // row landed.
        $actor = User::factory()->canImport()->create();
        $target = User::factory()->create(['username' => 'nonote.user']);
        $asset = Asset::factory()->create([
            'asset_tag' => 'AHIST-NOTE-2',
            'assigned_to' => null,
            'assigned_type' => null,
        ]);

        $file = AssetHistoryImportFileBuilder::new([
            'assetTag' => $asset->asset_tag,
            'name' => $target->username,
            'email' => '',
            'checkoutDate' => now()->format('Y-m-d H:i:s'),
            'checkinDate' => now()->addDays(7)->format('Y-m-d H:i:s'),
        ]);
        $file->forget('notes');

        $import = Import::factory()->assetHistory()->create([
            'created_by' => $actor->id,
            'file_path' => $file->saveToImportsDirectory(),
        ]);

        $this->actingAsForApi($actor);
        $this->postJson(
            route('api.imports.importFile', ['import' => $import->id]),
            ['import-type' => 'assetHistory', 'import' => $import->id, 'match_username' => true],
        )->assertOk();

        $checkoutLog = Actionlog::where('item_id', $asset->id)
            ->where('action_type', 'checkout')
            ->first();
        $this->assertNotNull($checkoutLog);
        $this->assertStringContainsString(
            'from history importer',
            $checkoutLog->note,
            'Actionlog note should carry the auto-generated importer marker when the CSV omitted the Notes column.'
        );
    }

    public function test_asset_history_import_rejects_row_with_unrecognized_target_type(): void
    {
        // Typo scenario ("Locaiton", "gerbil"). Silently degrading to
        // user would produce a "user not matched" error for every row
        // and hide the actual cause. Reject with the actual bad value
        // in the message so the operator can fix their CSV.
        $actor = User::factory()->canImport()->create();
        $asset = Asset::factory()->create([
            'asset_tag' => 'AHIST-TT-BAD',
            'assigned_to' => null,
            'assigned_type' => null,
        ]);

        $file = AssetHistoryImportFileBuilder::new([
            'assetTag' => $asset->asset_tag,
            'name' => 'any.value',
            'email' => '',
            'checkoutDate' => now()->format('Y-m-d H:i:s'),
            'checkinDate' => '',
            'targetType' => 'Locaiton',
        ]);

        $import = Import::factory()->assetHistory()->create([
            'created_by' => $actor->id,
            'file_path' => $file->saveToImportsDirectory(),
        ]);

        $this->actingAsForApi($actor);
        $response = $this->postJson(
            route('api.imports.importFile', ['import' => $import->id]),
            ['import-type' => 'assetHistory', 'import' => $import->id],
        );
        $response->assertStatus(500);
        $this->assertEquals('import-errors', $response->json('status'));
        $this->assertArrayHasKey('Asset ' . $asset->asset_tag, $response->json('messages'));

        $asset->refresh();
        $this->assertNull($asset->assigned_to);
        $this->assertDatabaseMissing('action_logs', [
            'item_id' => $asset->id,
            'action_type' => 'checkout',
        ]);
    }

    public function test_asset_history_import_skips_row_when_location_target_not_matched(): void
    {
        // Location-target row where the CSV location name doesn't match
        // any existing location should surface a per-row error and NOT
        // touch the asset's assignment. Same shape as the user
        // not-matched case, distinct message.
        $actor = User::factory()->canImport()->create();
        $asset = Asset::factory()->create([
            'asset_tag' => 'AHIST-LOC-MISS',
            'assigned_to' => null,
            'assigned_type' => null,
        ]);

        $file = AssetHistoryImportFileBuilder::new([
            'assetTag' => $asset->asset_tag,
            'name' => 'no.such.location',
            'email' => '',
            'checkoutDate' => now()->format('Y-m-d H:i:s'),
            'checkinDate' => '',
            'targetType' => 'location',
        ]);

        $import = Import::factory()->assetHistory()->create([
            'created_by' => $actor->id,
            'file_path' => $file->saveToImportsDirectory(),
        ]);

        $this->actingAsForApi($actor);
        $response = $this->postJson(
            route('api.imports.importFile', ['import' => $import->id]),
            ['import-type' => 'assetHistory', 'import' => $import->id],
        );
        $response->assertStatus(500);
        $this->assertEquals('import-errors', $response->json('status'));
        $this->assertArrayHasKey('Asset ' . $asset->asset_tag, $response->json('messages'));

        $asset->refresh();
        $this->assertNull($asset->assigned_to);
        $this->assertDatabaseMissing('action_logs', [
            'item_id' => $asset->id,
            'action_type' => 'checkout',
        ]);
    }
}
