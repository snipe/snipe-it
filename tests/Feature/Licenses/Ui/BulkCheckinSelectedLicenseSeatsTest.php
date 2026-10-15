<?php

namespace Tests\Feature\Licenses\Ui;

use App\Events\CheckoutableCheckedIn;
use App\Models\Asset;
use App\Models\Company;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\TestCase;

class BulkCheckinSelectedLicenseSeatsTest extends TestCase implements TestsPermissionsRequirement
{
    public function test_requires_permission()
    {
        $seat = LicenseSeat::factory()->assignedToUser()->create();

        $this->actingAs(User::factory()->create())
            ->post(route('licenses.bulkcheckin.selected'), ['ids' => [$seat->id]])
            ->assertForbidden();
    }

    public function test_can_bulk_checkin_seats_assigned_to_users()
    {
        Event::fake([CheckoutableCheckedIn::class]);

        $license = License::factory()->create(['seats' => 3]);
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $seat1 = LicenseSeat::factory()->assignedToUser($user1)->create(['license_id' => $license->id]);
        $seat2 = LicenseSeat::factory()->assignedToUser($user2)->create(['license_id' => $license->id]);

        $this->actingAs(User::factory()->checkinLicenses()->create())
            ->post(route('licenses.bulkcheckin.selected'), ['ids' => [$seat1->id, $seat2->id]])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertNull($seat1->fresh()->assigned_to);
        $this->assertNull($seat2->fresh()->assigned_to);

        Event::assertDispatched(CheckoutableCheckedIn::class, 2);
    }

    public function test_can_bulk_checkin_seats_assigned_to_assets()
    {
        Event::fake([CheckoutableCheckedIn::class]);

        $license = License::factory()->create(['seats' => 2]);
        $asset = Asset::factory()->create();
        $seat = LicenseSeat::factory()->assignedToAsset($asset)->create(['license_id' => $license->id]);

        $this->actingAs(User::factory()->checkinLicenses()->create())
            ->post(route('licenses.bulkcheckin.selected'), ['ids' => [$seat->id]])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertNull($seat->fresh()->asset_id);

        Event::assertDispatched(CheckoutableCheckedIn::class, 1);
    }

    public function test_empty_ids_returns_warning()
    {
        $this->actingAs(User::factory()->checkinLicenses()->create())
            ->post(route('licenses.bulkcheckin.selected'), ['ids' => []])
            ->assertRedirect()
            ->assertSessionHas('warning', trans('admin/licenses/general.bulk.checkin_selected.no_seats_selected'));
    }

    public function test_missing_ids_returns_warning()
    {
        $this->actingAs(User::factory()->checkinLicenses()->create())
            ->post(route('licenses.bulkcheckin.selected'), [])
            ->assertRedirect()
            ->assertSessionHas('warning', trans('admin/licenses/general.bulk.checkin_selected.no_seats_selected'));
    }

    public function test_unassigned_seats_in_submitted_ids_are_skipped()
    {
        Event::fake([CheckoutableCheckedIn::class]);

        $license = License::factory()->create(['seats' => 2]);
        $unassignedSeat = LicenseSeat::factory()->create(['license_id' => $license->id]);

        $this->actingAs(User::factory()->checkinLicenses()->create())
            ->post(route('licenses.bulkcheckin.selected'), ['ids' => [$unassignedSeat->id]])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertNull($unassignedSeat->fresh()->assigned_to);
        $this->assertNull($unassignedSeat->fresh()->asset_id);

        Event::assertNotDispatched(CheckoutableCheckedIn::class);
    }

    public function test_non_reassignable_license_marks_unreassignable_seat()
    {
        $license = License::factory()->create(['seats' => 2, 'reassignable' => false]);
        $user = User::factory()->create();
        $seat = LicenseSeat::factory()->assignedToUser($user)->create(['license_id' => $license->id]);

        $this->actingAs(User::factory()->checkinLicenses()->create())
            ->post(route('licenses.bulkcheckin.selected'), ['ids' => [$seat->id]])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertTrue((bool) $seat->fresh()->unreassignable_seat);
    }

    public function test_reassignable_license_does_not_mark_unreassignable_seat()
    {
        $license = License::factory()->create(['seats' => 2, 'reassignable' => true]);
        $user = User::factory()->create();
        $seat = LicenseSeat::factory()->assignedToUser($user)->create(['license_id' => $license->id]);

        $this->actingAs(User::factory()->checkinLicenses()->create())
            ->post(route('licenses.bulkcheckin.selected'), ['ids' => [$seat->id]])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertFalse((bool) $seat->fresh()->unreassignable_seat);
    }

    public function test_only_submitted_seat_ids_are_processed()
    {
        Event::fake([CheckoutableCheckedIn::class]);

        $license = License::factory()->create(['seats' => 3]);
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $seat1 = LicenseSeat::factory()->assignedToUser($user1)->create(['license_id' => $license->id]);
        $seat2 = LicenseSeat::factory()->assignedToUser($user2)->create(['license_id' => $license->id]);

        $this->actingAs(User::factory()->checkinLicenses()->create())
            ->post(route('licenses.bulkcheckin.selected'), ['ids' => [$seat1->id]])
            ->assertRedirect();

        $this->assertNull($seat1->fresh()->assigned_to);
        $this->assertNotNull($seat2->fresh()->assigned_to);

        Event::assertDispatched(CheckoutableCheckedIn::class, 1);
    }

    public function test_success_message_is_pluralized_correctly()
    {
        $license = License::factory()->create(['seats' => 3]);
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $seat1 = LicenseSeat::factory()->assignedToUser($user1)->create(['license_id' => $license->id]);
        $seat2 = LicenseSeat::factory()->assignedToUser($user2)->create(['license_id' => $license->id]);

        $this->actingAs(User::factory()->checkinLicenses()->create())
            ->post(route('licenses.bulkcheckin.selected'), ['ids' => [$seat1->id, $seat2->id]])
            ->assertSessionHas('success', trans_choice('admin/licenses/general.bulk.checkin_selected.success', 2, ['count' => 2]));
    }

    public function test_checkin_event_contains_correct_target_for_user_seat()
    {
        Event::fake([CheckoutableCheckedIn::class]);

        $license = License::factory()->create(['seats' => 2]);
        $targetUser = User::factory()->create();
        $seat = LicenseSeat::factory()->assignedToUser($targetUser)->create(['license_id' => $license->id]);

        $this->actingAs(User::factory()->checkinLicenses()->create())
            ->post(route('licenses.bulkcheckin.selected'), ['ids' => [$seat->id]]);

        Event::assertDispatched(CheckoutableCheckedIn::class, function ($event) use ($targetUser) {
            return $event->checkedOutTo->id === $targetUser->id;
        });
    }

    public function test_checkin_event_contains_correct_target_for_asset_seat()
    {
        Event::fake([CheckoutableCheckedIn::class]);

        $license = License::factory()->create(['seats' => 2]);
        $targetAsset = Asset::factory()->create();
        $seat = LicenseSeat::factory()->assignedToAsset($targetAsset)->create(['license_id' => $license->id]);

        $this->actingAs(User::factory()->checkinLicenses()->create())
            ->post(route('licenses.bulkcheckin.selected'), ['ids' => [$seat->id]]);

        Event::assertDispatched(CheckoutableCheckedIn::class, function ($event) use ($targetAsset) {
            return $event->checkedOutTo->id === $targetAsset->id;
        });
    }

    public function test_fmcs_prevents_checkin_of_seat_from_other_company()
    {
        Event::fake([CheckoutableCheckedIn::class]);

        [$myCompany, $otherCompany] = Company::factory()->count(2)->create();

        $actor = User::factory()->checkinLicenses()->forCompany($myCompany->id)->create();
        $otherLicense = License::factory()->create(['company_id' => $otherCompany->id, 'seats' => 2]);
        $targetUser = User::factory()->forCompany($otherCompany->id)->create();
        $seat = LicenseSeat::factory()->assignedToUser($targetUser)->create(['license_id' => $otherLicense->id]);

        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAs($actor)
            ->post(route('licenses.bulkcheckin.selected'), ['ids' => [$seat->id]])
            ->assertRedirect();

        $this->assertNotNull($seat->fresh()->assigned_to);

        Event::assertNotDispatched(CheckoutableCheckedIn::class);
    }
}
