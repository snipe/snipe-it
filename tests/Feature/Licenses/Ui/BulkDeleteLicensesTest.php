<?php

namespace Tests\Feature\Licenses\Ui;

use App\Models\Company;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\User;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\TestCase;

class BulkDeleteLicensesTest extends TestCase implements TestsPermissionsRequirement
{
    public function test_requires_permission()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('licenses.bulk.delete'), [
                'ids' => [1, 2, 3],
            ])
            ->assertForbidden();
    }

    public function test_licenses_without_checked_out_seats_can_be_bulk_deleted()
    {
        $license1 = License::factory()->create(['seats' => 5]);
        $license2 = License::factory()->create(['seats' => 5]);

        $this->actingAs(User::factory()->deleteLicenses()->create())
            ->post(route('licenses.bulk.delete'), [
                'ids' => [$license1->id, $license2->id],
            ])
            ->assertRedirect(route('licenses.index'))
            ->assertSessionHas('success', trans('admin/licenses/message.delete.bulk_success'));

        $this->assertSoftDeleted($license1);
        $this->assertSoftDeleted($license2);
    }

    public function test_licenses_with_checked_out_seats_cannot_be_bulk_deleted()
    {
        $license = License::factory()->create(['seats' => 5]);
        LicenseSeat::factory()->assignedToUser()->create(['license_id' => $license->id]);

        $this->actingAs(User::factory()->deleteLicenses()->create())
            ->post(route('licenses.bulk.delete'), [
                'ids' => [$license->id],
            ])
            ->assertRedirect(route('licenses.index'))
            ->assertSessionMissing('success');

        $this->assertModelExists($license);
        $this->assertNotSoftDeleted($license);
    }

    public function test_seats_are_cleaned_up_when_license_is_bulk_deleted()
    {
        $license = License::factory()->create(['seats' => 3]);

        $this->actingAs(User::factory()->deleteLicenses()->create())
            ->post(route('licenses.bulk.delete'), [
                'ids' => [$license->id],
            ])
            ->assertRedirect(route('licenses.index'));

        $this->assertSoftDeleted($license);
        $this->assertEquals(0, LicenseSeat::where('license_id', $license->id)->whereNotNull('assigned_to')->orWhere('license_id', $license->id)->whereNotNull('asset_id')->count());
    }

    public function test_fmcs_prevents_deleting_license_from_other_company()
    {
        [$myCompany, $otherCompany] = Company::factory()->count(2)->create();

        $actor = User::factory()->deleteLicenses()->forCompany($myCompany->id)->create();
        $otherLicense = License::factory()->create(['company_id' => $otherCompany->id, 'seats' => 1]);

        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAs($actor)
            ->post(route('licenses.bulk.delete'), [
                'ids' => [$otherLicense->id],
            ])
            ->assertRedirect(route('licenses.index'))
            ->assertSessionMissing('success');

        $this->assertModelExists($otherLicense);
        $this->assertNotSoftDeleted($otherLicense);
    }

    public function test_partial_success_when_some_licenses_have_checked_out_seats()
    {
        $cleanLicense = License::factory()->create(['seats' => 5]);
        $checkedOutLicense = License::factory()->create(['seats' => 5]);
        LicenseSeat::factory()->assignedToUser()->create(['license_id' => $checkedOutLicense->id]);

        $this->actingAs(User::factory()->deleteLicenses()->create())
            ->post(route('licenses.bulk.delete'), [
                'ids' => [$cleanLicense->id, $checkedOutLicense->id],
            ])
            ->assertRedirect(route('licenses.index'))
            ->assertSessionHas('success');

        $this->assertSoftDeleted($cleanLicense);
        $this->assertNotSoftDeleted($checkedOutLicense);
    }
}
