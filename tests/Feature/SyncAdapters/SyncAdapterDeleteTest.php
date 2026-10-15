<?php

namespace Tests\Feature\SyncAdapters;

use App\Models\SyncAdapterConfig;
use App\Models\SyncAdapterInstance;
use App\Models\User;
use Tests\TestCase;

/**
 * Adapter deletion from the settings page. Rows are always admin-created
 * post-refactor (no pre-seeded "built-in" instances), so the delete path
 * is uniform: superuser deletes, config rows go with the instance, and
 * asset_external_sources rows are intentionally left behind so past syncs
 * keep their history.
 */
class SyncAdapterDeleteTest extends TestCase
{
    public function test_delete_button_is_visible_when_an_adapter_is_selected()
    {
        $instance = SyncAdapterInstance::create([
            'adapter_type' => 'fleet',
            'label' => 'Prod Fleet',
        ]);

        $html = $this->actingAs(User::factory()->superuser()->create())
            ->get(route('settings.adapters.index', ['adapter' => $instance->slug]))
            ->assertOk()
            ->getContent();

        // Visibility is now owned by the wrapping #adapter-footer.
        // With an adapter selected on initial render the footer wrapper
        // must not carry an inline display: none, and the delete
        // trigger must point at the selected adapter's destroy URL.
        $this->assertMatchesRegularExpression(
            '/id="adapter-footer"(?![^>]*display:\s*none)/i',
            $html,
        );

        $this->assertStringContainsString(
            'data-href="'.route('settings.adapters.destroy', $instance->slug).'"',
            $html,
        );
    }

    public function test_tab_list_carries_the_destroy_url_for_the_js_toggle()
    {
        // The shown.bs.tab handler reads data-adapter-destroy-url off
        // the newly-active tab link to point the shared delete modal at
        // the right adapter. Assert the attribute renders per-tab.
        $instance = SyncAdapterInstance::create([
            'adapter_type' => 'fleet',
            'label' => 'Prod Fleet',
        ]);

        $html = $this->actingAs(User::factory()->superuser()->create())
            ->get(route('settings.adapters.index'))
            ->assertOk()
            ->getContent();

        $this->assertMatchesRegularExpression(
            '/data-adapter-name="'.$instance->slug.'"[^>]*data-adapter-destroy-url="'
                .preg_quote(route('settings.adapters.destroy', $instance->slug), '/').'"/',
            $html,
        );
    }

    public function test_unknown_adapter_slug_redirects_to_index_with_error()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('settings.adapters.index', ['adapter' => 'never-existed']))
            ->assertRedirect(route('settings.adapters.index'))
            ->assertSessionHas('error');
    }

    public function test_help_tab_is_default_active_when_no_adapters_are_configured()
    {
        // Fresh install (or a post-migrate install where the admin never
        // configured any of the seeded adapters) lands on the settings
        // page with zero rows. The help tab holds the getting-started
        // copy + list of supported types + CTA button, and is auto-
        // selected so the initial view is not just a blank pane.
        // Config now lives on the instance row as a JSON column, so
        // wiping the instances table also wipes their configs.
        \App\Models\SyncAdapterInstance::query()->delete();

        $html = $this->actingAs(User::factory()->superuser()->create())
            ->get(route('settings.adapters.index'))
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString(
            trans('admin/settings/sync_adapters.empty_state_title'),
            $html,
        );
        // Help pane is present and rendered active.
        $this->assertMatchesRegularExpression(
            '/id="adapter-pane-help"[^>]*class="[^"]*active in/',
            $html,
        );
        // The type catalog surfaces at least one shipped adapter so
        // admins can gauge scope before clicking Add adapter.
        $this->assertStringContainsString('Fleet', $html);
    }

    public function test_help_tab_is_always_rendered_even_when_adapters_exist()
    {
        // The help copy is not just an empty-state hint: it's a real
        // tab the admin can revisit after their first setup to see the
        // full list of shipped adapter types and the intro text.
        SyncAdapterInstance::create([
            'adapter_type' => 'fleet',
            'label' => 'Prod Fleet',
        ]);

        $html = $this->actingAs(User::factory()->superuser()->create())
            ->get(route('settings.adapters.index'))
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('id="adapter-pane-help"', $html);
        $this->assertStringContainsString(
            trans('admin/settings/sync_adapters.help_tab_label'),
            $html,
        );
    }

    public function test_delete_confirm_reflects_the_synced_asset_count()
    {
        // The delete-confirmation message should tell the admin how
        // many previously-synced assets reference this adapter so
        // they can gauge the impact before clicking through. Assets
        // are not deleted, but the external-source link is orphaned.
        $instance = SyncAdapterInstance::create([
            'adapter_type' => 'fleet',
            'label' => 'Prod Fleet',
        ]);

        // Two synced assets pointing at this adapter's slug. The
        // per-tab data-adapter-delete-confirm should reflect that
        // count so the tab-switch JS can update the trigger button.
        \App\Models\AssetExternalSource::create([
            'source' => $instance->slug,
            'external_id' => 'host-1',
            'asset_id' => \App\Models\Asset::factory()->create()->id,
        ]);
        \App\Models\AssetExternalSource::create([
            'source' => $instance->slug,
            'external_id' => 'host-2',
            'asset_id' => \App\Models\Asset::factory()->create()->id,
        ]);

        $html = $this->actingAs(User::factory()->superuser()->create())
            ->get(route('settings.adapters.index', ['adapter' => $instance->slug]))
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('2 previously-synced assets', $html);
    }

    public function test_delete_confirm_uses_zero_variant_when_no_assets_have_synced()
    {
        SyncAdapterInstance::create([
            'adapter_type' => 'fleet',
            'label' => 'Prod Fleet',
        ]);

        $html = $this->actingAs(User::factory()->superuser()->create())
            ->get(route('settings.adapters.index'))
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('No assets have been synced from this source yet', $html);
    }

    public function test_clone_creates_new_instance_and_copies_config()
    {
        // Same-vendor-across-companies is a real pain to hand-copy
        // (URL + token + mapping + defaults, times N tenants), so the
        // clone flow lifts every SyncAdapterConfig row from the source
        // instance into a fresh inactive instance whose company + label
        // the admin picks in the clone modal.
        $source = SyncAdapterInstance::create([
            'adapter_type' => 'fleet',
            'label' => 'Prod Fleet',
        ]);
        \App\Models\SyncAdapterConfig::put($source->id, 'url', 'https://fleet.example');
        \App\Models\SyncAdapterConfig::put($source->id, 'api_token', 'secret-token');
        \App\Models\SyncAdapterConfig::put($source->id, 'mapping.hostname', 'name');

        $newCompany = \App\Models\Company::factory()->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('settings.adapters.clone', $source->slug), [
                'label' => 'Prod Fleet - EU',
                'company_id' => $newCompany->id,
            ])
            ->assertRedirect(route('settings.adapters.index', ['adapter' => 'prod-fleet-eu']))
            ->assertSessionHas('success');

        $clone = SyncAdapterInstance::where('label', 'Prod Fleet - EU')->firstOrFail();

        $this->assertSame('fleet', $clone->adapter_type);
        $this->assertSame($newCompany->id, $clone->company_id);
        $this->assertFalse($clone->active);
        $this->assertNotSame($source->id, $clone->id);
        $this->assertNotSame($source->slug, $clone->slug);

        // Every config key from source shows up under the clone
        // with the same value. Storage is now a JSON blob on the
        // instance row, so we read through SyncAdapterConfig rather
        // than querying a settings table.
        $this->assertSame('https://fleet.example', SyncAdapterConfig::get($clone->id, 'url'));
        $this->assertSame('secret-token', SyncAdapterConfig::get($clone->id, 'api_token'));
        $this->assertSame('name', SyncAdapterConfig::get($clone->id, 'mapping.hostname'));

        // Source instance's config is untouched.
        $this->assertSame('https://fleet.example', SyncAdapterConfig::get($source->id, 'url'));
    }

    public function test_clone_rejects_duplicate_label()
    {
        $source = SyncAdapterInstance::create([
            'adapter_type' => 'fleet',
            'label' => 'Prod Fleet',
        ]);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('settings.adapters.clone', $source->slug), [
                'label' => 'Prod Fleet',
            ])
            ->assertSessionHasErrors('label');

        $this->assertSame(1, SyncAdapterInstance::where('label', 'Prod Fleet')->count());
    }

    public function test_backend_deletes_an_adapter_and_its_config_rows()
    {
        $instance = SyncAdapterInstance::create([
            'adapter_type' => 'fleet',
            'label' => 'Prod Fleet',
        ]);
        SyncAdapterConfig::put($instance->id, 'url', 'https://fleet.example');

        $this->actingAs(User::factory()->superuser()->create())
            ->delete(route('settings.adapters.destroy', $instance->slug))
            ->assertRedirect(route('settings.adapters.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('sync_adapter_instances', ['id' => $instance->id]);
    }
}
