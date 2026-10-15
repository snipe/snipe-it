<?php

namespace Tests\Feature\Checkouts\Api;

use App\Mail\CheckoutAccessoryMail;
use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Company;
use App\Models\Location;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\Support\MakesWatsonValidationLoud;
use Tests\TestCase;

class AccessoryCheckoutTest extends TestCase implements TestsPermissionsRequirement
{
    use MakesWatsonValidationLoud;

    public function test_requires_permission()
    {
        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.accessories.checkout', Accessory::factory()->create()))
            ->assertForbidden();
    }

    public function test_validation_when_checking_out_accessory()
    {
        $this->actingAsForApi(User::factory()->checkoutAccessories()->create())
            ->postJson(route('api.accessories.checkout', Accessory::factory()->create()), [
                // missing assigned_user, assigned_location, assigned_asset
            ])
            ->assertStatusMessageIs('error');
    }

    public function test_accessory_must_be_available_when_checking_out()
    {
        $this->actingAsForApi(User::factory()->checkoutAccessories()->create())
            ->postJson(route('api.accessories.checkout', Accessory::factory()->withoutItemsRemaining()->create()), [
                'assigned_user' => User::factory()->create()->id,
                'checkout_to_type' => 'user',
            ])
            ->assertOk()
            ->assertStatusMessageIs('error')
            ->assertJson(
                [
                    'status' => 'error',
                    'messages' => [
                        'checkout_qty' => [
                            trans_choice('admin/accessories/message.checkout.checkout_qty.lte', 0,
                                [
                                    'number_currently_remaining' => 0,
                                    'checkout_qty' => 1,
                                    'number_remaining_after_checkout' => 0,
                                ]),
                        ],

                    ],
                    'payload' => null,
                ])
            ->assertStatus(200)
            ->json();
    }

    public function test_accessory_can_be_checked_out_without_qty()
    {
        $accessory = Accessory::factory()->create();
        $user = User::factory()->create();
        $admin = User::factory()->checkoutAccessories()->create();

        $this->actingAsForApi($admin)
            ->postJson(route('api.accessories.checkout', $accessory), [
                'assigned_user' => $user->id,
                'checkout_to_type' => 'user',
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->assertStatus(200)
            ->assertJson(['messages' => trans('admin/accessories/message.checkout.success')])
            ->json();

        $this->assertTrue($accessory->checkouts()->where('assigned_type', User::class)->where('assigned_to', $user->id)->count() > 0);

        $this->assertEquals(
            1,
            Actionlog::where([
                'action_type' => 'checkout',
                'target_id' => $user->id,
                'target_type' => User::class,
                'item_id' => $accessory->id,
                'item_type' => Accessory::class,
                'created_by' => $admin->id,
            ])->count(), 'Log entry either does not exist or there are more than expected'
        );
        $this->assertHasTheseActionLogs($accessory, ['create', 'checkout']);
    }

    public function test_accessory_can_be_checked_out_with_qty()
    {
        $accessory = Accessory::factory()->create(['qty' => 20]);
        $user = User::factory()->create();
        $admin = User::factory()->checkoutAccessories()->create();

        $this->actingAsForApi($admin)
            ->postJson(route('api.accessories.checkout', $accessory), [
                'assigned_user' => $user->id,
                'checkout_to_type' => 'user',
                'checkout_qty' => 2,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success')
            ->assertStatus(200)
            ->assertJson(['messages' => trans('admin/accessories/message.checkout.success')])
            ->json();

        $this->assertTrue($accessory->checkouts()->where('assigned_type', User::class)->where('assigned_to', $user->id)->count() > 0);

        $this->assertDatabaseHas('action_logs', [
            'action_type' => 'checkout',
            'target_id' => $user->id,
            'target_type' => User::class,
            'item_id' => $accessory->id,
            'item_type' => Accessory::class,
            'quantity' => 2,
            'created_by' => $admin->id,
        ]);

        $this->assertHasTheseActionLogs($accessory, ['create', 'checkout']);
    }

    public function test_accessory_checkout_infers_user_target_when_checkout_to_type_omitted()
    {
        $accessory = Accessory::factory()->create();
        $user = User::factory()->create();

        $this->actingAsForApi(User::factory()->checkoutAccessories()->create())
            ->postJson(route('api.accessories.checkout', $accessory), [
                'assigned_user' => $user->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertSame(
            1,
            $accessory->checkouts()
                ->where('assigned_type', User::class)
                ->where('assigned_to', $user->id)
                ->count()
        );
    }

    public function test_accessory_checkout_infers_asset_target_when_checkout_to_type_omitted()
    {
        $accessory = Accessory::factory()->create();
        $asset = Asset::factory()->create();

        $this->actingAsForApi(User::factory()->checkoutAccessories()->create())
            ->postJson(route('api.accessories.checkout', $accessory), [
                'assigned_asset' => $asset->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertSame(
            1,
            $accessory->checkouts()
                ->where('assigned_type', Asset::class)
                ->where('assigned_to', $asset->id)
                ->count()
        );
    }

    public function test_accessory_checkout_infers_location_target_when_checkout_to_type_omitted()
    {
        $accessory = Accessory::factory()->create();
        $location = Location::factory()->create();

        $this->actingAsForApi(User::factory()->checkoutAccessories()->create())
            ->postJson(route('api.accessories.checkout', $accessory), [
                'assigned_location' => $location->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertSame(
            1,
            $accessory->checkouts()
                ->where('assigned_type', Location::class)
                ->where('assigned_to', $location->id)
                ->count()
        );
    }

    public function test_accessory_checkout_rejects_multiple_target_fields()
    {
        $accessory = Accessory::factory()->create();
        $user = User::factory()->create();
        $location = Location::factory()->create();

        $response = $this->actingAsForApi(User::factory()->checkoutAccessories()->create())
            ->postJson(route('api.accessories.checkout', $accessory), [
                'assigned_user' => $user->id,
                'assigned_location' => $location->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('error');

        $this->assertArrayHasKey('assigned_user', $response->json('messages'));
        $this->assertSame(0, $accessory->checkouts()->count());
    }

    public function test_accessory_cannot_be_checked_out_to_invalid_user()
    {
        $accessory = Accessory::factory()->create();
        $user = User::factory()->create();

        $this->actingAsForApi(User::factory()->checkoutAccessories()->create())
            ->postJson(route('api.accessories.checkout', $accessory), [
                'assigned_user' => 'invalid-user-id',
                'checkout_to_type' => 'user',
                'note' => 'oh hi there',
            ])
            ->assertOk()
            ->assertStatusMessageIs('error')
            ->assertStatus(200)
            ->json();

        $this->assertFalse($accessory->checkouts()->where('assigned_type', User::class)->where('assigned_to', $user->id)->count() > 0);
    }

    public function test_user_sent_notification_upon_checkout()
    {
        Mail::fake();

        $accessory = Accessory::factory()->requiringAcceptance()->create();
        $user = User::factory()->create();

        $this->actingAsForApi(User::factory()->checkoutAccessories()->create())
            ->postJson(route('api.accessories.checkout', $accessory), [
                'assigned_user' => $user->id,
                'checkout_to_type' => 'user',
            ]);

        Mail::assertSent(CheckoutAccessoryMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    public function test_action_log_created_upon_checkout()
    {
        $accessory = Accessory::factory()->create();
        $actor = User::factory()->checkoutAccessories()->create();
        $user = User::factory()->create();

        $this->actingAsForApi($actor)
            ->postJson(route('api.accessories.checkout', $accessory), [
                'assigned_user' => $user->id,
                'checkout_to_type' => 'user',
                'note' => 'oh hi there',
            ]);

        $this->assertEquals(
            1,
            Actionlog::where([
                'action_type' => 'checkout',
                'target_id' => $user->id,
                'target_type' => User::class,
                'item_id' => $accessory->id,
                'item_type' => Accessory::class,
                'created_by' => $actor->id,
                'note' => 'oh hi there',
            ])->count(),
            'Log entry either does not exist or there are more than expected'
        );
        $this->assertHasTheseActionLogs($accessory, ['create', 'checkout']);

    }

    public function test_superuser_cannot_checkout_accessory_to_a_target_in_another_company_when_full_company_support_is_enabled()
    {
        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $superuser = User::factory()->superuser()->withoutCompany()->create();
        $accessoryInCompanyA = Accessory::factory()->for($companyA)->create(['qty' => 1]);
        $userInCompanyB = User::factory()->forCompany($companyB)->create();

        $this->actingAsForApi($superuser)
            ->postJson(route('api.accessories.checkout', $accessoryInCompanyA), [
                'assigned_user' => $userInCompanyB->id,
                'checkout_to_type' => 'user',
                'checkout_qty' => 1,
            ])
            ->assertOk()
            ->assertStatusMessageIs('error')
            ->assertMessagesAre(trans('general.error_user_company'));

        $this->assertDatabaseMissing('accessories_checkout', [
            'accessory_id' => $accessoryInCompanyA->id,
            'assigned_to' => $userInCompanyB->id,
            'assigned_type' => User::class,
        ]);

        $this->assertDatabaseMissing('action_logs', [
            'created_by' => $superuser->id,
            'action_type' => 'checkout',
            'target_type' => User::class,
            'target_id' => $userInCompanyB->id,
            'item_type' => Accessory::class,
            'item_id' => $accessoryInCompanyA->id,
        ]);

        $this->assertEquals(1, $accessoryInCompanyA->fresh()->numRemaining());
    }

    public function test_user_in_same_company_can_checkout_accessory_when_full_company_support_is_enabled()
    {
        $this->settings->enableMultipleFullCompanySupport();

        $company = Company::factory()->create();
        $accessory = Accessory::factory()->for($company)->create(['qty' => 5]);
        $target = $company->users()->save(User::factory()->make());
        $actor = User::factory()->superuser()->create();

        $this->actingAsForApi($actor)
            ->postJson(route('api.accessories.checkout', $accessory), [
                'assigned_user' => $target->id,
                'checkout_to_type' => 'user',
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');
    }

    public function test_user_in_multiple_companies_can_checkout_accessory_from_any_of_their_companies_when_full_company_support_is_enabled()
    {
        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB] = Company::factory()->count(2)->create();
        $target = User::factory()->create();
        $target->companies()->sync([$companyA->id, $companyB->id]);

        $accessoryInA = Accessory::factory()->for($companyA)->create(['qty' => 5]);
        $accessoryInB = Accessory::factory()->for($companyB)->create(['qty' => 5]);
        $actor = User::factory()->superuser()->create();

        $this->actingAsForApi($actor)
            ->postJson(route('api.accessories.checkout', $accessoryInA), [
                'assigned_user' => $target->id,
                'checkout_to_type' => 'user',
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->actingAsForApi($actor)
            ->postJson(route('api.accessories.checkout', $accessoryInB), [
                'assigned_user' => $target->id,
                'checkout_to_type' => 'user',
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');
    }

    /**
     * Regression: AccessoriesController's FMCS check called $target->companies()
     * unconditionally, which only exists on User. Checking an accessory out to
     * a Location or Asset target under FMCS crashed with BadMethodCallException
     * (500). Fix swapped the User-only pivot lookup for $accessory->canCheckoutTo(),
     * matching what the web controller and AssetsController already use.
     */
    public function test_accessory_can_be_checked_out_to_location_when_fmcs_enabled()
    {
        $this->settings->enableMultipleFullCompanySupport();

        $company = Company::factory()->create();
        $accessory = Accessory::factory()->for($company)->create();
        $location = Location::factory()->create(['company_id' => $company->id]);
        $actor = User::factory()->superuser()->create();

        $this->actingAsForApi($actor)
            ->postJson(route('api.accessories.checkout', $accessory), [
                'assigned_location' => $location->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertSame(
            1,
            $accessory->checkouts()
                ->where('assigned_type', Location::class)
                ->where('assigned_to', $location->id)
                ->count()
        );
    }

    public function test_accessory_can_be_checked_out_to_asset_when_fmcs_enabled()
    {
        $this->settings->enableMultipleFullCompanySupport();

        $company = Company::factory()->create();
        $accessory = Accessory::factory()->for($company)->create();
        $targetAsset = Asset::factory()->for($company)->create();
        $actor = User::factory()->superuser()->create();

        $this->actingAsForApi($actor)
            ->postJson(route('api.accessories.checkout', $accessory), [
                'assigned_asset' => $targetAsset->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertSame(
            1,
            $accessory->checkouts()
                ->where('assigned_type', Asset::class)
                ->where('assigned_to', $targetAsset->id)
                ->count()
        );
    }

    public function test_accessory_cannot_be_checked_out_to_location_in_different_company_when_fmcs_scoped_locations_enabled()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();
        $accessory = Accessory::factory()->for($companyA)->create();
        $locationInB = Location::factory()->create(['company_id' => $companyB->id]);
        $actor = User::factory()->superuser()->create();

        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();

        $this->actingAsForApi($actor)
            ->postJson(route('api.accessories.checkout', $accessory), [
                'assigned_location' => $locationInB->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('error')
            ->assertMessagesAre(trans('general.error_user_company'));

        $this->assertSame(0, $accessory->checkouts()->count());
    }

    public function test_accessory_cannot_be_checked_out_to_asset_in_different_company_when_fmcs_enabled()
    {
        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB] = Company::factory()->count(2)->create();
        $accessory = Accessory::factory()->for($companyA)->create();
        $assetInB = Asset::factory()->for($companyB)->create();
        $actor = User::factory()->superuser()->create();

        $this->actingAsForApi($actor)
            ->postJson(route('api.accessories.checkout', $accessory), [
                'assigned_asset' => $assetInB->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('error')
            ->assertMessagesAre(trans('general.error_user_company'));

        $this->assertSame(0, $accessory->checkouts()->count());
    }

    public function test_accessory_can_be_checked_out_to_cross_company_location_when_fmcs_location_scoping_is_off()
    {
        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB] = Company::factory()->count(2)->create();
        $accessory = Accessory::factory()->for($companyA)->create();
        $locationInB = Location::factory()->create(['company_id' => $companyB->id]);
        $actor = User::factory()->superuser()->create();

        $this->actingAsForApi($actor)
            ->postJson(route('api.accessories.checkout', $accessory), [
                'assigned_location' => $locationInB->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertSame(
            1,
            $accessory->checkouts()
                ->where('assigned_type', Location::class)
                ->where('assigned_to', $locationInB->id)
                ->count()
        );
    }

    public function test_accessory_can_be_checked_out_to_child_company_location_under_scoped_fmcs()
    {
        $parent = Company::factory()->create();
        $child = Company::factory()->childOf($parent)->create();
        $accessory = Accessory::factory()->for($parent)->create();
        $locationInChild = Location::factory()->create(['company_id' => $child->id]);
        $actor = User::factory()->superuser()->create();

        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();

        $this->actingAsForApi($actor)
            ->postJson(route('api.accessories.checkout', $accessory), [
                'assigned_location' => $locationInChild->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertSame(
            1,
            $accessory->checkouts()
                ->where('assigned_type', Location::class)
                ->where('assigned_to', $locationInChild->id)
                ->count()
        );
    }

    public function test_accessory_can_be_checked_out_to_null_company_location_in_floater_mode()
    {
        $this->settings->enableFloaterMode();

        $company = Company::factory()->create();
        $accessory = Accessory::factory()->for($company)->create();
        $locationWithNoCompany = Location::factory()->create(['company_id' => null]);
        $actor = User::factory()->superuser()->create();

        $this->actingAsForApi($actor)
            ->postJson(route('api.accessories.checkout', $accessory), [
                'assigned_location' => $locationWithNoCompany->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');

        $this->assertSame(
            1,
            $accessory->checkouts()
                ->where('assigned_type', Location::class)
                ->where('assigned_to', $locationWithNoCompany->id)
                ->count()
        );
    }

    /**
     * Security regression pin: sibling to the consumable race test.
     * AccessoryCheckoutRequest validates number_remaining_after_checkout
     * with an unlocked numRemaining() read. Two racing checkouts for a
     * qty=1 accessory both used to pass validation and both attach pivot
     * rows. Fix wraps the writes in DB::transaction with a lockForUpdate
     * re-check. This test pre-drains the pivot to simulate the "someone
     * else grabbed it" moment and asserts we refuse.
     */
    public function test_checkout_refuses_when_inventory_is_already_exhausted(): void
    {
        $target = User::factory()->create();
        $accessory = Accessory::factory()->create(['qty' => 1]);
        $actor = User::factory()->superuser()->create();

        \App\Models\AccessoryCheckout::create([
            'accessory_id' => $accessory->id,
            'assigned_to' => $target->id,
            'assigned_type' => User::class,
            'created_by' => $actor->id,
        ]);

        $this->assertSame(0, $accessory->fresh()->numRemaining());

        $this->actingAsForApi($actor)
            ->postJson(route('api.accessories.checkout', $accessory), [
                'assigned_user' => $target->id,
                'checkout_to_type' => 'user',
                'checkout_qty' => 1,
            ])
            ->assertStatusMessageIs('error');

        $this->assertSame(1, $accessory->checkouts()->count(), 'A second pivot row would mean the register went negative');
        $this->assertSame(0, $accessory->fresh()->numRemaining());
    }
}
