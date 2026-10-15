<?php

namespace Tests\Feature\Assets\Ui;

use App\Models\Asset;
use App\Models\Company;
use App\Models\Location;
use App\Models\User;
use Tests\TestCase;

/**
 * End-to-end regression coverage for the v8.7.0 check-in location
 * regression. Complements the scope-level pin in
 * tests/Feature/Fmcs/LocationScopingSettingTest.php.
 *
 * Symptom (reported by a paying customer on 8.7.2, three-tier admin
 * setup with Super / State / Campus): non-superuser scoped admins with
 * `assets.checkin` permission get "The assigned location could not be
 * found" on the check-in submit path. Super Admin unaffected because
 * they bypass FMCS entirely. Root cause was
 * `Company::scopeCompanyablesDirectly()` ignoring the
 * scope_locations_fmcs setting for the locations table, so
 * `AssetCheckinController::store()`'s `Location::find($id)` returned
 * null for any location outside the actor's pivot memberships even
 * when the install had opted out of location-level tenant scoping.
 *
 * These tests hit the real HTTP endpoint so any future controller
 * regression (added scope-respecting find, tightened validation on the
 * FormRequest, etc.) is caught end-to-end and not just at the model
 * layer.
 */
class CheckinAssetLocationScopingTest extends TestCase
{
    private Company $companyA;

    private Company $companyB;

    private User $scopedAdmin;

    private User $checkedOutTo;

    protected function setUp(): void
    {
        parent::setUp();

        [$this->companyA, $this->companyB] = Company::factory()->count(2)->create();

        // Non-superuser scoped admin, pivoted to Company A only, holding
        // assets.checkin. This is the "Campus Admin" tier in the
        // customer's setup.
        $this->scopedAdmin = $this->companyA->users()->save(
            User::factory()->checkinAssets()->make()
        );

        // Somebody to check the asset out to so it's in a checked-out
        // state at the top of the check-in flow. Their tenant doesn't
        // matter for the scope check on the LOCATION field.
        $this->checkedOutTo = $this->companyA->users()->save(User::factory()->make());
    }

    /**
     * Seed a location without going through Watson\ValidatingTrait's
     * fmcs_company validator. Same rationale as the sibling scope test
     * file: we assert read-side scope behavior on the check-in path,
     * so the write-side rule is out of scope for the fixture.
     */
    private function seedLocation(?int $companyId): Location
    {
        $location = Location::factory()->make();
        $location->company_id = $companyId;
        $location->setValidating(false);
        $location->save();

        return $location->refresh();
    }

    private function seedCheckedOutAsset(Location $location): Asset
    {
        // Use the assignedToUser() factory state so the resulting asset
        // matches the shape Snipe-IT normally produces for a checked-out
        // asset (assigned_to + assigned_type + last_checkout in sync)
        // rather than a hand-rolled combination. rtd_location_id is
        // still forced to the fixture location so the check-in form
        // pre-populates the picker with the target.
        return Asset::factory()
            ->for($this->companyA)
            ->assignedToUser($this->checkedOutTo)
            ->create([
                'rtd_location_id' => $location->id,
                'location_id' => $location->id,
            ]);
    }

    // -----------------------------------------------------------------
    // The exact customer configuration: FMCS on, location scoping off,
    // floater off. Scoped admin must be able to check in an asset even
    // when the submitted location is one their pivot memberships would
    // hide under strict scoping.
    // -----------------------------------------------------------------

    public function test_scoped_admin_can_check_in_when_location_scoping_is_off_and_target_is_null_company(): void
    {
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();

        $nullCompanyLocation = $this->seedLocation(null);
        $asset = $this->seedCheckedOutAsset($nullCompanyLocation);
        $this->actingAs($this->scopedAdmin)
            ->post(route('hardware.checkin.store', $asset->id), [
                'name' => $asset->name,
                'location_id' => $nullCompanyLocation->id,
                'rtd_location_id' => $nullCompanyLocation->id,
                'redirect_option' => 'index',
            ])
            ->assertRedirect(route('hardware.index'))
            ->assertSessionHas('success')
            ->assertSessionMissing('error');

        $this->assertNull(
            $asset->fresh()->assigned_to,
            'Asset should have been checked in (assigned_to cleared).'
        );
    }

    public function test_scoped_admin_can_check_in_when_location_scoping_is_off_and_target_is_cross_company(): void
    {
        // Location assigned to Company B, actor pivoted only to Company A.
        // With location scoping off, cross-company location targets are
        // supposed to work.
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();

        $companyBLocation = $this->seedLocation($this->companyB->id);
        $asset = $this->seedCheckedOutAsset($companyBLocation);
        $this->actingAs($this->scopedAdmin)
            ->post(route('hardware.checkin.store', $asset->id), [
                'name' => $asset->name,
                'location_id' => $companyBLocation->id,
                'rtd_location_id' => $companyBLocation->id,
                'redirect_option' => 'index',
            ])
            ->assertRedirect(route('hardware.index'))
            ->assertSessionHas('success')
            ->assertSessionMissing('error');

        $this->assertNull($asset->fresh()->assigned_to);
    }

    // -----------------------------------------------------------------
    // scope_locations_fmcs ON: regression guard so the fix doesn't
    // silently loosen the strict-scoping path. When location scoping IS
    // on and the location is cross-tenant, the check-in submit should
    // still refuse the location, matching pre-fix strict semantics.
    // -----------------------------------------------------------------

    public function test_scoped_admin_still_blocked_when_location_scoping_is_on_and_target_is_cross_company(): void
    {
        // Regression guard for the strict-scoping path. Seed the asset
        // at its own tenant's location (which the scoped admin CAN see),
        // then have the check-in SUBMIT try to route it to a cross-
        // tenant location. Under scope_locations_fmcs=1, Location::find
        // inside the check-in controller returns null on the cross-
        // tenant id and the submit gets rejected. Seeding the asset the
        // other way around (rtd_location_id already cross-tenant) is not
        // a valid state under strict scoping — the fmcs_location
        // validator would reject that save regardless of actor.
        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();
        $this->settings->disableFloaterMode();

        $companyALocation = $this->seedLocation($this->companyA->id);
        $companyBLocation = $this->seedLocation($this->companyB->id);
        $asset = $this->seedCheckedOutAsset($companyALocation);

        $this->actingAs($this->scopedAdmin)
            ->post(route('hardware.checkin.store', $asset->id), [
                'name' => $asset->name,
                'location_id' => $companyBLocation->id,
                'rtd_location_id' => $companyBLocation->id,
                'redirect_option' => 'index',
            ])
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertNotNull(
            $asset->fresh()->assigned_to,
            'Asset should NOT have been checked in — cross-tenant location under strict scoping must be refused.'
        );
    }
}
