<?php

namespace Tests\Feature\Checkouts\Ui;

use App\Models\Asset;
use App\Models\CheckoutAcceptance;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\User;
use Tests\TestCase;

class LicenseCheckoutTest extends TestCase
{
    public function test_page_renders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('licenses.checkout', License::factory()->create()->id))
            ->assertOk();
    }

    public function test_notes_are_stored_in_action_log_on_checkout_to_asset()
    {
        $admin = User::factory()->superuser()->create();
        $asset = Asset::factory()->create();
        $licenseSeat = LicenseSeat::factory()->create();

        $this->actingAs($admin)
            ->post(route('licenses.checkout', $licenseSeat->license), [
                'checkout_to_type' => 'asset',
                'assigned_user' => null,
                'assigned_asset' => $asset->id,
                'notes' => 'oh hi there',
            ]);

        $this->assertDatabaseHas('action_logs', [
            'action_type' => 'checkout',
            'target_id' => $asset->id,
            'target_type' => Asset::class,
            'item_id' => $licenseSeat->license->id,
            'item_type' => License::class,
            'note' => 'oh hi there',
        ]);
        $this->assertHasTheseActionLogs($licenseSeat->license, ['add seats', 'create', 'checkout']); // TODO - TOTALLY out-of-order
    }

    public function test_notes_are_stored_in_action_log_on_checkout_to_user()
    {
        $admin = User::factory()->superuser()->create();
        $licenseSeat = LicenseSeat::factory()->create();

        $this->actingAs($admin)
            ->post(route('licenses.checkout', $licenseSeat->license), [
                'checkout_to_type' => 'user',
                'assigned_user' => $admin->id,
                'assigned_asset' => null,
                'notes' => 'oh hi there',
            ]);

        $this->assertDatabaseHas('action_logs', [
            'action_type' => 'checkout',
            'target_id' => $admin->id,
            'target_type' => User::class,
            'item_id' => $licenseSeat->license->id,
            'item_type' => License::class,
            'note' => 'oh hi there',
        ]);
        $this->assertHasTheseActionLogs($licenseSeat->license, ['add seats', 'create', 'checkout']); // FIXME - out-of-order
    }

    public function test_license_checkout_page_post_is_redirected_if_redirect_selection_is_index()
    {
        $license = License::factory()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->from(route('licenses.checkout', $license))
            ->post(route('licenses.checkout', $license), [
                'assigned_user' => User::factory()->create()->id,
                'redirect_option' => 'index',
                'assigned_qty' => 1,
            ])
            ->assertStatus(302)
            ->assertRedirect(route('licenses.index'));
    }

    public function test_license_checkout_page_post_is_redirected_if_redirect_selection_is_item()
    {
        $license = License::factory()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->from(route('licenses.checkout', $license))
            ->post(route('licenses.checkout', $license), [
                'assigned_user' => User::factory()->create()->id,
                'redirect_option' => 'item',
            ])
            ->assertStatus(302)
            ->assertRedirect(route('licenses.show', $license));
    }

    public function test_license_checkout_page_post_is_redirected_if_redirect_selection_is_user_target()
    {
        $user = User::factory()->create();
        $license = License::factory()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->from(route('licenses.checkout', $license))
            ->post(route('licenses.checkout', $license), [
                'assigned_user' => $user->id,
                'redirect_option' => 'target',
            ])
            ->assertStatus(302)
            ->assertRedirect(route('users.show', $user));
    }

    public function test_license_checkout_page_post_is_redirected_if_redirect_selection_is_asset_target()
    {
        $asset = Asset::factory()->create();
        $license = License::factory()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->from(route('licenses.checkout', $license))
            ->post(route('licenses.checkout', $license), [
                'assigned_asset' => $asset->id,
                'redirect_option' => 'target',
            ])
            ->assertStatus(302)
            ->assertRedirect(route('hardware.show', $asset));
    }

    public function test_license_checkout_page_post_redirects_to_signature_page_when_sign_in_place_is_checked()
    {
        $targetUser = User::factory()->create();
        $seat = LicenseSeat::factory()->requiringAcceptance()->create();

        $response = $this->actingAs(User::factory()->admin()->create())
            ->from(route('licenses.checkout', $seat->license))
            ->post(route('licenses.checkout', $seat->license), [
                'assigned_user' => $targetUser->id,
                'redirect_option' => 'index',
                'sign_in_place' => 1,
            ]);

        $acceptance = CheckoutAcceptance::query()
            ->where('checkoutable_type', LicenseSeat::class)
            ->where('assigned_to_id', $targetUser->id)
            ->pending()
            ->latest()
            ->first();

        $this->assertNotNull($acceptance);
        $this->assertDatabaseCount('checkout_acceptances', 1);

        $response->assertStatus(302)
            ->assertRedirect(route('account.accept.item', $acceptance));
    }

    public function test_license_sign_in_place_creates_acceptance_when_acceptance_not_required()
    {
        $targetUser = User::factory()->create();
        $seat = LicenseSeat::factory()->create();

        $response = $this->actingAs(User::factory()->admin()->create())
            ->from(route('licenses.checkout', $seat->license))
            ->post(route('licenses.checkout', $seat->license), [
                'assigned_user' => $targetUser->id,
                'redirect_option' => 'index',
                'sign_in_place' => 1,
            ]);

        $acceptance = CheckoutAcceptance::query()
            ->where('checkoutable_type', LicenseSeat::class)
            ->where('assigned_to_id', $targetUser->id)
            ->pending()
            ->latest()
            ->first();

        $this->assertNotNull($acceptance);
        // The fallback does not set qty, so it stays null (the column default).
        $this->assertNull($acceptance->qty);
        $this->assertDatabaseCount('checkout_acceptances', 1);

        $response->assertStatus(302)
            ->assertRedirect(route('account.accept.item', $acceptance));
    }

    public function test_license_checkout_stores_sign_in_place_preference_in_session()
    {
        $targetUser = User::factory()->create();
        $seat = LicenseSeat::factory()->create();

        $response = $this->actingAs(User::factory()->admin()->create())
            ->post(route('licenses.checkout', $seat->license), [
                'assigned_user' => $targetUser->id,
                'redirect_option' => 'index',
                'sign_in_place' => 1,
            ]);

        $response->assertSessionHas('sign_in_place', true);
    }

    // -----------------------------------------------------------------------
    // GHSA-r25g-f428-466r regression coverage.
    //
    // Web license checkout must reject explicit-seat-id requests that target
    // a retired unreassignable seat (which would push a non-reassignable
    // license past its intended activation count) or an already-occupied seat
    // (which would silently displace the current holder with no audit trail).
    // The web path has no reassign opt-in flag: any reassignment goes through
    // the API's `reassign: true` request or through the UserItemTransferController
    // seat-transfer flow, which produce a proper checkin-then-checkout event
    // pair.
    // -----------------------------------------------------------------------

    public function test_web_checkout_by_explicit_seat_id_rejects_retired_unreassignable_seat()
    {
        $license = License::factory()->create(['seats' => 2, 'reassignable' => 0]);
        $seats = $license->licenseseats()->orderBy('id')->get();
        $retiredSeat = $seats[0];
        // unreassignable_seat is not fillable, so ->update() would silently
        // skip it. Direct property assignment + save persists it.
        $retiredSeat->unreassignable_seat = true;
        $retiredSeat->assigned_to = null;
        $retiredSeat->save();

        $target = User::factory()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->post(route('licenses.checkout.save', ['licenseId' => $license->id, 'seatId' => $retiredSeat->id]), [
                'assigned_user' => $target->id,
                'redirect_option' => 'index',
            ])
            ->assertSessionHas('error');

        $this->assertNull($retiredSeat->fresh()->assigned_to);
        $this->assertTrue((bool) $retiredSeat->fresh()->unreassignable_seat);
    }

    public function test_web_checkout_by_explicit_seat_id_rejects_seat_already_assigned_to_user()
    {
        $license = License::factory()->create(['seats' => 2]);
        $seats = $license->licenseseats()->orderBy('id')->get();

        $originalHolder = User::factory()->create();
        $seats[0]->update(['assigned_to' => $originalHolder->id]);

        $newTarget = User::factory()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->post(route('licenses.checkout.save', ['licenseId' => $license->id, 'seatId' => $seats[0]->id]), [
                'assigned_user' => $newTarget->id,
                'redirect_option' => 'index',
            ])
            ->assertSessionHas('error');

        $this->assertEquals(
            $originalHolder->id,
            $seats[0]->fresh()->assigned_to,
            'Web checkout must never silently displace the current holder.',
        );
    }
}
