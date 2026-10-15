<?php

namespace Tests\Feature\Importing\Api;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\Importing\CleansUpImportFiles;
use Tests\TestCase;

/**
 * Regression test for cross-user storage-key collision on the import upload
 * endpoint. The storage key used to be `date('Y-m-d-his').'-'.basename` with
 * no uploader component, so two callers posting the same filename inside the
 * same second resolved to the same key and the second putFileAs silently
 * overwrote the first. The uploader-id prefix added to the key eliminates
 * that cross-user collision class.
 */
class ImportStorageKeyIsolationTest extends TestCase
{
    use CleansUpImportFiles;

    #[Test]
    public function two_users_uploading_the_same_filename_in_the_same_second_do_not_clobber_each_other(): void
    {
        Carbon::setTestNow('2026-10-05 12:34:56');

        $victim = User::factory()->canImport()->create();
        $attacker = User::factory()->canImport()->create();

        $victimBytes = "name,email\nVictim,victim@example.test\n";
        $attackerBytes = "name,email\nAttacker,attacker@example.test\n";

        $victimResponse = $this->actingAsForApi($victim)
            ->postJson(route('api.imports.store'), [
                'files' => [UploadedFile::fake()->createWithContent('inventory.csv', $victimBytes)],
            ])
            ->assertOk();

        $attackerResponse = $this->actingAsForApi($attacker)
            ->postJson(route('api.imports.store'), [
                'files' => [UploadedFile::fake()->createWithContent('inventory.csv', $attackerBytes)],
            ])
            ->assertOk();

        $victimKey = $victimResponse->json('files.0.file_path');
        $attackerKey = $attackerResponse->json('files.0.file_path');

        $this->assertNotSame($victimKey, $attackerKey, 'Two uploaders at the same second must not share a storage key.');
        $this->assertStringContainsString((string) $victim->id, $victimKey);
        $this->assertStringContainsString((string) $attacker->id, $attackerKey);

        $this->assertSame($victimBytes, Storage::get('private_uploads/imports/'.$victimKey));
        $this->assertSame($attackerBytes, Storage::get('private_uploads/imports/'.$attackerKey));
    }
}
