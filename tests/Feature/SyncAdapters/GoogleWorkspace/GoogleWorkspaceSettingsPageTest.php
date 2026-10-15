<?php

namespace Tests\Feature\SyncAdapters\GoogleWorkspace;

use App\Models\Category;
use App\Models\Statuslabel;
use App\Models\SyncAdapterConfig;
use App\Models\SyncAdapterInstance;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

/**
 * Smoke coverage for the Google Workspace (ChromeOS) adapter's
 * registration + settings-page presence. The schema mixes three
 * non-secret fields (service account email, impersonate admin email,
 * customer id) with one secret (the private key), so this test proves
 * the SyncAdapter base's per-schema encryption dispatch works:
 * secret gets encrypted at rest, plain-text fields stay plain.
 */
class GoogleWorkspaceSettingsPageTest extends TestCase
{
    public function test_google_workspace_tab_renders_on_the_adapters_page()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('settings.adapters.index'))
            ->assertOk()
            ->assertSee('Google Workspace (ChromeOS)')
            ->assertSee('Service Account Email')
            ->assertSee('Service Account Private Key')
            ->assertSee('Impersonate Admin Email')
            ->assertSee('Customer ID');
    }

    public function test_saving_google_workspace_encrypts_only_the_private_key()
    {
        $instance = SyncAdapterInstance::where('slug', 'google_workspace')->firstOrFail();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('settings.adapters.save', $instance), [
                'google_workspace_service_account_email' => 'snipeit-sync@my-project.iam.gserviceaccount.com',
                'google_workspace_private_key' => "-----BEGIN PRIVATE KEY-----\nfake-key-material\n-----END PRIVATE KEY-----",
                'google_workspace_impersonate_email' => 'admin@example.test',
                'google_workspace_customer_id' => 'my_customer',
                'google_workspace_default_category_id' => Category::factory()->create()->id,
                'google_workspace_default_status_id' => Statuslabel::factory()->rtd()->create()->id,
            ])
            ->assertRedirect(route('settings.adapters.index', ['adapter' => $instance->slug]));

        // Non-secret fields land as plain text so admins can audit
        // which service account a Snipe-IT instance is talking to
        // without a decrypt step.
        $this->assertSame(
            'snipeit-sync@my-project.iam.gserviceaccount.com',
            SyncAdapterConfig::get($instance->id, 'service_account_email'),
        );
        $this->assertSame('admin@example.test', SyncAdapterConfig::get($instance->id, 'impersonate_email'));
        $this->assertSame('my_customer', SyncAdapterConfig::get($instance->id, 'customer_id'));

        // Secret field is Crypt-encrypted at rest. A regression that
        // stored the private key plain would surface here.
        $storedKey = SyncAdapterConfig::get($instance->id, 'private_key');
        $this->assertStringNotContainsString('fake-key-material', $storedKey);
        $this->assertStringContainsString('fake-key-material', Crypt::decrypt($storedKey));
    }

    public function test_blank_credentials_on_save_fail_validation()
    {
        $instance = SyncAdapterInstance::where('slug', 'google_workspace')->firstOrFail();
        SyncAdapterConfig::put($instance->id, 'service_account_email', 'existing-sa@example.test');
        SyncAdapterConfig::put($instance->id, 'impersonate_email', 'existing-admin@example.test');
        SyncAdapterConfig::put($instance->id, 'private_key', Crypt::encrypt('existing-key-material'));

        $this->actingAs(User::factory()->superuser()->create())
            ->from(route('settings.adapters.index', ['adapter' => $instance->slug]))
            ->post(route('settings.adapters.save', $instance), [
                'google_workspace_service_account_email' => '',
                'google_workspace_private_key' => '',
                'google_workspace_impersonate_email' => '',
                'google_workspace_default_category_id' => Category::factory()->create()->id,
                'google_workspace_default_status_id' => Statuslabel::factory()->rtd()->create()->id,
            ])
            ->assertRedirect()
            ->assertSessionHasErrors([
                'google_workspace_service_account_email',
                'google_workspace_private_key',
                'google_workspace_impersonate_email',
            ]);

        // Nothing persisted since the save was rejected. Prior values
        // stay intact.
        $this->assertSame('existing-sa@example.test', SyncAdapterConfig::get($instance->id, 'service_account_email'));
        $this->assertSame('existing-admin@example.test', SyncAdapterConfig::get($instance->id, 'impersonate_email'));
        $this->assertSame('existing-key-material', Crypt::decrypt(SyncAdapterConfig::get($instance->id, 'private_key')));
    }
}
