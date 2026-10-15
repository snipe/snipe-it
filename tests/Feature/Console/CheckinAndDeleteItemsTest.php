<?php

namespace Tests\Feature\Console;

use App\Events\CheckoutableCheckedIn;
use App\Models\Accessory;
use App\Models\Asset;
use App\Models\Company;
use App\Models\Component;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CheckinAndDeleteItemsTest extends TestCase
{
    // ---------------------------------------------------------------------------
    // Assets
    // ---------------------------------------------------------------------------

    public function test_checked_out_asset_is_checked_in_and_soft_deleted()
    {
        $user = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($user)->create();

        $this->assertNotNull($asset->assigned_to);

        $this->artisan('snipeit:checkin-delete-all', ['--type' => 'assets', '--force' => true])
            ->assertExitCode(0);

        $this->assertSoftDeleted($asset);
        $this->assertNull($asset->fresh()->assigned_to);
    }

    public function test_unassigned_asset_is_soft_deleted_without_checkin_log()
    {
        $asset = Asset::factory()->create();

        $this->assertNull($asset->assigned_to);

        $this->artisan('snipeit:checkin-delete-all', ['--type' => 'assets', '--force' => true])
            ->assertExitCode(0);

        $this->assertSoftDeleted($asset);
    }

    public function test_asset_checkin_creates_action_log()
    {
        $user = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($user)->create();

        $this->artisan('snipeit:checkin-delete-all', ['--type' => 'assets', '--force' => true, '--no-notifications' => true])
            ->assertExitCode(0);

        $this->assertHasTheseActionLogs($asset, ['create', 'checkin from', 'delete']);
    }

    public function test_event_is_fired_for_checked_out_asset_when_notifications_enabled()
    {
        Event::fake([CheckoutableCheckedIn::class]);

        User::factory()->superuser()->create();
        $asset = Asset::factory()->assignedToUser()->create();

        $this->artisan('snipeit:checkin-delete-all', ['--type' => 'assets', '--force' => true])
            ->assertExitCode(0);

        Event::assertDispatched(CheckoutableCheckedIn::class, function ($event) use ($asset) {
            return $event->checkoutable->is($asset);
        });
    }

    public function test_admin_id_option_is_used_as_checked_in_by_user()
    {
        Event::fake([CheckoutableCheckedIn::class]);

        $admin = User::factory()->superuser()->create();
        $asset = Asset::factory()->assignedToUser()->create();

        $this->artisan('snipeit:checkin-delete-all', ['--type' => 'assets', '--force' => true, '--admin-id' => $admin->id])
            ->assertExitCode(0);

        Event::assertDispatched(CheckoutableCheckedIn::class, function ($event) use ($admin) {
            return $event->checkedInBy->is($admin);
        });
    }

    public function test_invalid_admin_id_returns_exit_code_1()
    {
        $this->artisan('snipeit:checkin-delete-all', ['--type' => 'assets', '--force' => true, '--admin-id' => 999999])
            ->assertExitCode(1);
    }

    public function test_event_is_not_fired_when_no_notifications_option_set()
    {
        Event::fake([CheckoutableCheckedIn::class]);

        $asset = Asset::factory()->assignedToUser()->create();

        $this->artisan('snipeit:checkin-delete-all', ['--type' => 'assets', '--force' => true, '--no-notifications' => true])
            ->assertExitCode(0);

        Event::assertNotDispatched(CheckoutableCheckedIn::class);
    }

    public function test_company_id_option_scopes_assets()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $assetA = Asset::factory()->for($companyA)->assignedToUser()->create();
        $assetB = Asset::factory()->for($companyB)->assignedToUser()->create();

        $this->artisan('snipeit:checkin-delete-all', [
            '--type' => 'assets',
            '--company-id' => $companyA->id,
            '--force' => true,
            '--no-notifications' => true,
        ])->assertExitCode(0);

        $this->assertSoftDeleted($assetA);
        $this->assertNotSoftDeleted($assetB);
    }

    public function test_asset_license_seats_are_freed_on_checkin()
    {
        $user = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($user)->create();
        $seat = LicenseSeat::factory()->create(['asset_id' => $asset->id, 'assigned_to' => $user->id]);

        $this->artisan('snipeit:checkin-delete-all', ['--type' => 'assets', '--force' => true, '--no-notifications' => true])
            ->assertExitCode(0);

        $this->assertNull($seat->fresh()->assigned_to);
    }

    // ---------------------------------------------------------------------------
    // Licenses
    // ---------------------------------------------------------------------------

    public function test_assigned_license_seat_is_checked_in_and_license_soft_deleted()
    {
        $license = License::factory()->create();
        $seat = LicenseSeat::factory()->for($license)->assignedToUser()->create();

        $this->assertNotNull($seat->assigned_to);

        $this->artisan('snipeit:checkin-delete-all', ['--type' => 'licenses', '--force' => true, '--no-notifications' => true])
            ->assertExitCode(0);

        $this->assertSoftDeleted($license);
        $this->assertNull($seat->fresh()->assigned_to);
        $this->assertNull($seat->fresh()->asset_id);
    }

    public function test_unassigned_license_is_soft_deleted()
    {
        $license = License::factory()->create();

        $this->artisan('snipeit:checkin-delete-all', ['--type' => 'licenses', '--force' => true, '--no-notifications' => true])
            ->assertExitCode(0);

        $this->assertSoftDeleted($license);
    }

    public function test_company_id_option_scopes_licenses()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $licenseA = License::factory()->for($companyA)->create();
        $licenseB = License::factory()->for($companyB)->create();

        $this->artisan('snipeit:checkin-delete-all', [
            '--type' => 'licenses',
            '--company-id' => $companyA->id,
            '--force' => true,
            '--no-notifications' => true,
        ])->assertExitCode(0);

        $this->assertSoftDeleted($licenseA);
        $this->assertNotSoftDeleted($licenseB);
    }

    // ---------------------------------------------------------------------------
    // Accessories
    // ---------------------------------------------------------------------------

    public function test_checked_out_accessory_is_checked_in_and_soft_deleted()
    {
        $accessory = Accessory::factory()->checkedOutToUser()->create();

        $this->assertEquals(1, $accessory->checkouts->count());

        $this->artisan('snipeit:checkin-delete-all', ['--type' => 'accessories', '--force' => true, '--no-notifications' => true])
            ->assertExitCode(0);

        $this->assertSoftDeleted($accessory);
        $this->assertEquals(0, $accessory->fresh()->checkouts->count());
    }

    public function test_company_id_option_scopes_accessories()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $accessoryA = Accessory::factory()->for($companyA)->checkedOutToUser()->create();
        $accessoryB = Accessory::factory()->for($companyB)->checkedOutToUser()->create();

        $this->artisan('snipeit:checkin-delete-all', [
            '--type' => 'accessories',
            '--company-id' => $companyA->id,
            '--force' => true,
            '--no-notifications' => true,
        ])->assertExitCode(0);

        $this->assertSoftDeleted($accessoryA);
        $this->assertNotSoftDeleted($accessoryB);
    }

    // ---------------------------------------------------------------------------
    // Components
    // ---------------------------------------------------------------------------

    public function test_checked_out_component_is_checked_in_and_soft_deleted()
    {
        $component = Component::factory()->checkedOutToAsset()->create();

        $this->assertDatabaseHas('components_assets', ['component_id' => $component->id]);

        $this->artisan('snipeit:checkin-delete-all', ['--type' => 'components', '--force' => true, '--no-notifications' => true])
            ->assertExitCode(0);

        $this->assertSoftDeleted($component);
        $this->assertDatabaseMissing('components_assets', ['component_id' => $component->id]);
    }

    public function test_company_id_option_scopes_components()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $componentA = Component::factory()->for($companyA)->checkedOutToAsset()->create();
        $componentB = Component::factory()->for($companyB)->checkedOutToAsset()->create();

        $this->artisan('snipeit:checkin-delete-all', [
            '--type' => 'components',
            '--company-id' => $companyA->id,
            '--force' => true,
            '--no-notifications' => true,
        ])->assertExitCode(0);

        $this->assertSoftDeleted($componentA);
        $this->assertNotSoftDeleted($componentB);
    }

    // ---------------------------------------------------------------------------
    // Type filtering and general behaviour
    // ---------------------------------------------------------------------------

    public function test_type_option_limits_processing_to_specified_type()
    {
        $asset = Asset::factory()->assignedToUser()->create();
        $accessory = Accessory::factory()->checkedOutToUser()->create();

        $this->artisan('snipeit:checkin-delete-all', ['--type' => 'assets', '--force' => true, '--no-notifications' => true])
            ->assertExitCode(0);

        $this->assertSoftDeleted($asset);
        $this->assertNotSoftDeleted($accessory);
    }

    public function test_invalid_type_returns_exit_code_1()
    {
        $this->artisan('snipeit:checkin-delete-all', ['--type' => 'invalid', '--force' => true])
            ->assertExitCode(1);
    }

    public function test_confirmation_is_required_without_force()
    {
        Asset::factory()->create();

        $this->artisan('snipeit:checkin-delete-all', ['--type' => 'assets'])
            ->expectsConfirmation('This will check in and soft-delete all [assets] for [all companies]. Continue?', 'no')
            ->assertExitCode(0);

        $this->assertDatabaseCount('assets', 1);
    }

    public function test_force_option_skips_confirmation()
    {
        $asset = Asset::factory()->create();

        $this->artisan('snipeit:checkin-delete-all', ['--type' => 'assets', '--force' => true, '--no-notifications' => true])
            ->assertExitCode(0);

        $this->assertSoftDeleted($asset);
    }

    public function test_dry_run_does_not_delete_or_checkin_assets()
    {
        $user = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($user)->create();

        $this->artisan('snipeit:checkin-delete-all', ['--type' => 'assets', '--dry-run' => true])
            ->assertExitCode(0);

        $this->assertNotSoftDeleted($asset);
        $this->assertNotNull($asset->fresh()->assigned_to);
    }

    public function test_dry_run_skips_confirmation_prompt()
    {
        Asset::factory()->create();

        // Would hang waiting for input if confirmation were shown
        $this->artisan('snipeit:checkin-delete-all', ['--type' => 'assets', '--dry-run' => true])
            ->assertExitCode(0);
    }

    public function test_dry_run_outputs_would_be_messaging()
    {
        $asset = Asset::factory()->assignedToUser()->create();

        $this->artisan('snipeit:checkin-delete-all', ['--type' => 'assets', '--dry-run' => true])
            ->expectsOutputToContain('DRY RUN')
            ->expectsOutputToContain('Would check in asset')
            ->expectsOutputToContain('Would delete asset')
            ->expectsOutputToContain('Dry run complete')
            ->assertExitCode(0);
    }

    public function test_custom_note_is_used_in_action_log()
    {
        $asset = Asset::factory()->assignedToUser()->create();

        $this->artisan('snipeit:checkin-delete-all', [
            '--type' => 'assets',
            '--force' => true,
            '--no-notifications' => true,
            '--note' => 'Bulk removal for decommission',
        ])->assertExitCode(0);

        $this->assertDatabaseHas('action_logs', [
            'item_id' => $asset->id,
            'action_type' => 'checkin from',
            'note' => 'Bulk removal for decommission',
        ]);
    }
}
