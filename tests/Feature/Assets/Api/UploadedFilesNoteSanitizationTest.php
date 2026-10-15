<?php

namespace Tests\Feature\Assets\Api;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\User;
use Tests\TestCase;

/**
 *
 * The uploaded-file `note` reaches the browser through the API's
 * UploadedFilesTransformer. The client-side gallery custom view concatenates
 * it into the `data-footer` attribute of a bootstrap-table lightbox anchor,
 * and ekko-lightbox later re-parses that value as an HTML string when
 * building the modal footer. Two decodes strip a single `e()` entity encode,
 * so the transformer now strip_tags() before e()ing to leave the value inert
 * regardless of how many parse passes happen downstream. These tests pin the
 * transformer contract.
 */
class UploadedFilesNoteSanitizationTest extends TestCase
{
    private function seedUploadWithNote(Asset $asset, User $actor, string $note): Actionlog
    {
        $log = new Actionlog;
        $log->item_id = $asset->id;
        $log->item_type = Asset::class;
        $log->action_type = 'uploaded';
        $log->filename = 'attacker.png';
        $log->note = $note;
        $log->created_by = $actor->id;
        $log->save();

        return $log;
    }

    private function fetchNoteFromApi(Asset $asset, User $viewer): ?string
    {
        $response = $this->actingAsForApi($viewer)
            ->get(route('api.files.index', [
                'object_type' => 'assets',
                'id' => $asset->id,
            ]))
            ->assertOk();

        return $response->json('rows.0.note');
    }

    public function test_note_containing_html_tags_is_stripped_before_transport(): void
    {
        $viewer = User::factory()->superuser()->create();
        $uploader = User::factory()->create();
        $asset = Asset::factory()->create();

        $this->seedUploadWithNote($asset, $uploader, '<img src=x onerror="alert(1)">');

        $this->assertSame('', $this->fetchNoteFromApi($asset, $viewer));
    }

    public function test_note_containing_script_tag_is_stripped_before_transport(): void
    {
        $viewer = User::factory()->superuser()->create();
        $uploader = User::factory()->create();
        $asset = Asset::factory()->create();

        $this->seedUploadWithNote($asset, $uploader, 'hi <script>alert(1)</script> there');

        // strip_tags removes the tag markers. The content between the tags
        // is preserved as plain text (which is the point: this is a
        // free-text notes field, not a markup field), but the tag itself is
        // gone so no re-parse downstream can reconstruct an element.
        $this->assertSame('hi alert(1) there', $this->fetchNoteFromApi($asset, $viewer));
    }

    public function test_note_with_plain_text_and_punctuation_survives_intact(): void
    {
        $viewer = User::factory()->superuser()->create();
        $uploader = User::factory()->create();
        $asset = Asset::factory()->create();

        $original = 'Delivered by "Acme Freight" - box #7 (fragile). Ok?';
        $this->seedUploadWithNote($asset, $uploader, $original);

        // The API path e()s after strip_tags, so quotes and ampersands
        // come back entity-encoded. Assert on the decoded form so the test
        // pins the semantic (plain text preserved) rather than the exact
        // encoding, which is a display detail.
        $this->assertSame($original, html_entity_decode(
            $this->fetchNoteFromApi($asset, $viewer),
            ENT_QUOTES | ENT_HTML5,
            'UTF-8'
        ));
    }

    public function test_empty_note_remains_null(): void
    {
        $viewer = User::factory()->superuser()->create();
        $uploader = User::factory()->create();
        $asset = Asset::factory()->create();

        $log = new Actionlog;
        $log->item_id = $asset->id;
        $log->item_type = Asset::class;
        $log->action_type = 'uploaded';
        $log->filename = 'plain.png';
        $log->note = null;
        $log->created_by = $uploader->id;
        $log->save();

        $this->assertNull($this->fetchNoteFromApi($asset, $viewer));
    }
}
