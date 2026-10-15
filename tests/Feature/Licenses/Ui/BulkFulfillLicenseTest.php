<?php

namespace Tests\Feature\Licenses\Ui;

use App\Enums\CheckoutRequestState;
use App\Models\CheckoutRequest;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * Bulk-fulfill flow for Licenses. Same user-target contract as
 * accessories/consumables but qty is pinned to 1 per row - licenses
 * are one-seat-per-requester by convention (nobody realistically
 * asks for N seats of Photoshop for themselves). The controller
 * pins qty server-side so a hand-crafted POST can't over-allocate.
 * Each ticked row claims one seat via freeSeat(lock:true).
 */
class BulkFulfillLicenseTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    public function test_requires_checkout_permission_on_licenses(): void
    {
        $license = License::factory()->create(['seats' => 5]);

        $this->actingAs(User::factory()->create())
            ->get(route('licenses.fulfill-requests.create', $license))
            ->assertForbidden();
    }

    public function test_show_hides_qty_input(): void
    {
        // License-specific: qty is fixed at 1 per row, so the
        // per-row picker doesn't render a qty input. Controller
        // passes hideQty=true to the view.
        $admin = User::factory()->checkoutLicenses()->create();
        $license = License::factory()->create(['seats' => 5]);
        CheckoutRequest::factory()->create([
            'user_id' => User::factory()->create()->id,
            'requestable_id' => $license->id,
            'requestable_type' => License::class,
        ]);

        $this->actingAs($admin)
            ->get(route('licenses.fulfill-requests.create', $license))
            ->assertOk()
            ->assertViewHas('hideQty', true);
    }

    public function test_fulfills_ticked_rows_by_claiming_one_seat_each(): void
    {
        $admin = User::factory()->checkoutLicenses()->create();
        $license = License::factory()->create(['seats' => 5]);
        $alice = User::factory()->create();
        $bob = User::factory()->create();

        $aliceReq = CheckoutRequest::factory()->create([
            'user_id' => $alice->id,
            'requestable_id' => $license->id,
            'requestable_type' => License::class,
        ]);
        $bobReq = CheckoutRequest::factory()->create([
            'user_id' => $bob->id,
            'requestable_id' => $license->id,
            'requestable_type' => License::class,
        ]);

        $this->actingAs($admin)
            ->post(route('licenses.fulfill-requests.store', $license), [
                'enabled_requests' => [$aliceReq->id => '1', $bobReq->id => '1'],
                'user_id' => [
                    $aliceReq->id => $alice->id,
                    $bobReq->id => $bob->id,
                ],
                // Even if the POST claims a higher qty, the
                // controller pins to 1 (see next test).
                'qty' => [
                    $aliceReq->id => 1,
                    $bobReq->id => 1,
                ],
                'notes' => [],
            ])
            ->assertRedirect(route('requests.index'));

        $this->assertSame(CheckoutRequestState::Fulfilled, $aliceReq->fresh()->state);
        $this->assertSame(CheckoutRequestState::Fulfilled, $bobReq->fresh()->state);

        $this->assertSame(1, LicenseSeat::where('license_id', $license->id)
            ->where('assigned_to', $alice->id)->count());
        $this->assertSame(1, LicenseSeat::where('license_id', $license->id)
            ->where('assigned_to', $bob->id)->count());
    }

    public function test_hand_crafted_qty_above_one_is_pinned_to_one_server_side(): void
    {
        // Belt: even if the POST claims qty=5, the controller
        // ignores it and claims exactly one seat. One-seat-per-
        // request is a hard invariant, not just a UI convention.
        $admin = User::factory()->checkoutLicenses()->create();
        $license = License::factory()->create(['seats' => 10]);
        $requester = User::factory()->create();

        $request = CheckoutRequest::factory()->create([
            'user_id' => $requester->id,
            'requestable_id' => $license->id,
            'requestable_type' => License::class,
        ]);

        $this->actingAs($admin)
            ->post(route('licenses.fulfill-requests.store', $license), [
                'enabled_requests' => [$request->id => '1'],
                'user_id' => [$request->id => $requester->id],
                'qty' => [$request->id => 99],
                'notes' => [],
            ])
            ->assertRedirect(route('requests.index'));

        $this->assertSame(1, LicenseSeat::where('license_id', $license->id)
            ->where('assigned_to', $requester->id)->count());
    }
}
