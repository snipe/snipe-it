<?php

namespace Tests\Feature\Licenses\Ui;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Company;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\User;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\TestCase;

class BulkDeleteWithCheckinLicensesTest extends TestCase implements TestsPermissionsRequirement
{
    public function test_requires_permission()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('licenses.bulk.delete'), [
                'bulk_actions' => 'delete_with_checkin',
                'ids' => [1, 2, 3],
            ])
            ->assertForbidden();
    }

    public function test_delete_with_checkin_deletes_license_with_user_assigned_seat()
    {
        $license = License::factory()->create(['seats' => 3]);
        $seat = LicenseSeat::factory()->assignedToUser()->create(['license_id' => $license->id]);
        $assignedUser = $seat->user;

        $this->actingAs(User::factory()->deleteLicenses()->checkinLicenses()->create())
            ->post(route('licenses.bulk.delete'), [
                'bulk_actions' => 'delete_with_checkin',
                'ids' => [$license->id],
            ])
            ->assertRedirect(route('licenses.index'))
            ->assertSessionHas('success');

        $this->assertSoftDeleted($license);

        $this->assertDatabaseHas('action_logs', [
            'action_type' => 'checkin from',
            'target_id' => $assignedUser->id,
            'target_type' => User::class,
            'item_type' => License::class,
            'item_id' => $license->id,
        ]);
    }

    public function test_delete_with_checkin_deletes_license_with_asset_assigned_seat()
    {
        $license = License::factory()->create(['seats' => 3]);
        $asset = Asset::factory()->create();
        LicenseSeat::factory()->assignedToAsset($asset)->create(['license_id' => $license->id]);

        $this->actingAs(User::factory()->deleteLicenses()->checkinLicenses()->create())
            ->post(route('licenses.bulk.delete'), [
                'bulk_actions' => 'delete_with_checkin',
                'ids' => [$license->id],
            ])
            ->assertRedirect(route('licenses.index'))
            ->assertSessionHas('success');

        $this->assertSoftDeleted($license);

        $this->assertDatabaseHas('action_logs', [
            'action_type' => 'checkin from',
            'target_id' => $asset->id,
            'target_type' => Asset::class,
            'item_type' => License::class,
            'item_id' => $license->id,
        ]);
    }

    public function test_delete_with_checkin_works_across_mixed_selection()
    {
        $cleanLicense = License::factory()->create(['seats' => 3]);
        $checkedOutLicense = License::factory()->create(['seats' => 3]);
        LicenseSeat::factory()->assignedToUser()->create(['license_id' => $checkedOutLicense->id]);

        $this->actingAs(User::factory()->deleteLicenses()->checkinLicenses()->create())
            ->post(route('licenses.bulk.delete'), [
                'bulk_actions' => 'delete_with_checkin',
                'ids' => [$cleanLicense->id, $checkedOutLicense->id],
            ])
            ->assertRedirect(route('licenses.index'))
            ->assertSessionHas('success');

        $this->assertSoftDeleted($cleanLicense);
        $this->assertSoftDeleted($checkedOutLicense);
    }

    public function test_delete_with_checkin_processes_multiple_seats_per_license()
    {
        $license = License::factory()->create(['seats' => 4]);
        LicenseSeat::factory()->count(2)->assignedToUser()->create(['license_id' => $license->id]);
        $asset = Asset::factory()->create();
        LicenseSeat::factory()->assignedToAsset($asset)->create(['license_id' => $license->id]);

        $this->actingAs(User::factory()->deleteLicenses()->checkinLicenses()->create())
            ->post(route('licenses.bulk.delete'), [
                'bulk_actions' => 'delete_with_checkin',
                'ids' => [$license->id],
            ])
            ->assertRedirect(route('licenses.index'))
            ->assertSessionHas('success');

        $this->assertSoftDeleted($license);

        $this->assertEquals(
            3,
            Actionlog::where('action_type', 'checkin from')
                ->where('item_type', License::class)
                ->where('item_id', $license->id)
                ->count()
        );
    }

    public function test_delete_defaults_to_plain_delete_when_bulk_actions_missing()
    {
        // Backwards compat: existing form POSTs with no bulk_actions key should still
        // execute the original delete-only behavior and refuse licenses with assigned seats.
        $license = License::factory()->create(['seats' => 3]);
        LicenseSeat::factory()->assignedToUser()->create(['license_id' => $license->id]);

        $this->actingAs(User::factory()->deleteLicenses()->create())
            ->post(route('licenses.bulk.delete'), [
                'ids' => [$license->id],
            ])
            ->assertRedirect(route('licenses.index'))
            ->assertSessionMissing('success');

        $this->assertNotSoftDeleted($license);
    }

    public function test_delete_with_checkin_requires_both_delete_and_checkin_permission()
    {
        $license = License::factory()->create(['seats' => 3]);
        LicenseSeat::factory()->assignedToUser()->create(['license_id' => $license->id]);

        // User has delete but not checkin. The seat-checkin step must refuse.
        $this->actingAs(User::factory()->deleteLicenses()->create())
            ->post(route('licenses.bulk.delete'), [
                'bulk_actions' => 'delete_with_checkin',
                'ids' => [$license->id],
            ])
            ->assertRedirect(route('licenses.index'))
            ->assertSessionMissing('success');

        $this->assertNotSoftDeleted($license);
    }

    public function test_fmcs_prevents_delete_with_checkin_from_other_company()
    {
        [$myCompany, $otherCompany] = Company::factory()->count(2)->create();

        $actor = User::factory()->deleteLicenses()->checkinLicenses()->forCompany($myCompany->id)->create();
        $otherLicense = License::factory()->create(['company_id' => $otherCompany->id, 'seats' => 2]);
        LicenseSeat::factory()->assignedToUser()->create(['license_id' => $otherLicense->id]);

        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAs($actor)
            ->post(route('licenses.bulk.delete'), [
                'bulk_actions' => 'delete_with_checkin',
                'ids' => [$otherLicense->id],
            ])
            ->assertRedirect(route('licenses.index'))
            ->assertSessionMissing('success');

        $this->assertModelExists($otherLicense);
        $this->assertNotSoftDeleted($otherLicense);
    }
}
