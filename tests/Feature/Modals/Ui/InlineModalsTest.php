<?php

namespace Tests\Feature\Modals\Ui;

use App\Models\Asset;
use App\Models\License;
use App\Models\User;
use Tests\TestCase;

/**
 * Render coverage for the standalone modals migrated to blade
 * components: upload-file, add-note, and confirm-action. These are
 * inlined via `x-modals.*` on their host pages rather than loaded via
 * ModalController::show, so ShowModalsTest can't cover them. Instead
 * we hit real pages that render each modal and assert the expected
 * id + action url.
 */
class InlineModalsTest extends TestCase
{
    public function test_upload_file_modal_renders_on_asset_view(): void
    {
        $asset = Asset::factory()->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('hardware.show', $asset))
            ->assertOk()
            ->assertSee('id="uploadFileModal"', false)
            ->assertSee(route('ui.files.store', ['object_type' => 'assets', 'id' => $asset->id]));
    }

    public function test_add_note_modal_renders_on_asset_view(): void
    {
        $asset = Asset::factory()->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('hardware.show', $asset))
            ->assertOk()
            ->assertSee('id="createNoteModal"', false)
            ->assertSee(route('notes.store'));
    }

    public function test_confirm_action_modal_renders_on_license_view(): void
    {
        $license = License::factory()->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('licenses.show', $license))
            ->assertOk()
            ->assertSee('id="checkinFromAllModal"', false)
            ->assertSee('id="checkoutFromAllModal"', false)
            ->assertSee(route('licenses.bulkcheckin', $license->id))
            ->assertSee(route('licenses.bulkcheckout', $license->id));
    }
}
