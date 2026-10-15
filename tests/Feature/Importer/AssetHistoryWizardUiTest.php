<?php

namespace Tests\Feature\Importer;

use App\Livewire\Importer;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Wizard-level regression coverage for the assetHistory import type.
 *
 * The wizard exposes a few checkboxes that are meaningful for CRUD
 * imports (welcome-email, update-existing, etc.) but nonsensical for
 * the assetHistory type because that importer only writes actionlogs
 * against existing rows. This file pins the "not shown" branches so
 * future edits to the shared wizard template don't accidentally
 * re-enable them.
 */
class AssetHistoryWizardUiTest extends TestCase
{
    public function test_send_welcome_checkbox_is_not_rendered_on_asset_history_type(): void
    {
        // AssetHistoryImporter's resolveTargetUser() only queries the
        // users table (see the private method's body). It never creates
        // users, so a "send welcome email to newly-created users"
        // checkbox is dead UI here. hasUserCheckoutMapping IS true for
        // assetHistory because its field_map contains full_name, so the
        // guard has to be on the typeOfImport itself.
        $this->actingAs(User::factory()->superuser()->create());

        $component = Livewire::test(Importer::class)
            ->set('typeOfImport', 'assetHistory')
            ->set('wizardStep', 1);

        $component->assertDontSee('name="send_welcome"', false);
    }

    public function test_send_welcome_checkbox_is_still_rendered_on_user_type(): void
    {
        // Positive-side regression guard: the exclusion added for
        // assetHistory must not leak into the user import type, where
        // the checkbox is load-bearing.
        $this->actingAs(User::factory()->superuser()->create());

        $component = Livewire::test(Importer::class)
            ->set('typeOfImport', 'user')
            ->set('wizardStep', 1);

        $component->assertSee('name="send_welcome"', false);
    }
}
