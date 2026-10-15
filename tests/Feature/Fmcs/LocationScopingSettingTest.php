<?php

namespace Tests\Feature\Fmcs;

use App\Models\Asset;
use App\Models\Company;
use App\Models\Location;
use App\Models\User;
use Tests\TestCase;

/**
 * Regression coverage for the v8.7.0 asset check-in regression where
 * scoped admins (State / Campus tier — non-superusers with limited
 * company_user pivot memberships) started hitting "The assigned
 * location could not be found" on the check-in submit path.
 *
 * Root cause: Company::scopeCompanyablesDirectly() was applying the
 * CompanyableScope to the locations table unconditionally under FMCS,
 * regardless of the scope_locations_fmcs setting. Snipe-IT already
 * treats scope_locations_fmcs as the opt-in switch for location
 * tenant-scoping elsewhere (CompanyableTrait::canCheckoutTo(),
 * LocationsController write paths, the location select2 endpoint's
 * parent-hierarchy filter). The global scope needed to as well.
 *
 * Behavior pinned here:
 *   - scope_locations_fmcs OFF (default): all locations visible to
 *     every actor, regardless of pivot memberships. This is the
 *     "shared locations across tenants" configuration.
 *   - scope_locations_fmcs ON: the CompanyableScope fires normally and
 *     locations are filtered to the actor's pivot memberships (with
 *     the null-company / floater rules the scope already implements).
 *
 * The end-to-end check-in HTTP regression is covered in
 * tests/Feature/Assets/Ui/CheckinAssetLocationScopingTest.php; this
 * file gates the scope semantics that make it work.
 */
class LocationScopingSettingTest extends TestCase
{
    private Company $companyA;

    private Company $companyB;

    private User $scopedActor;

    protected function setUp(): void
    {
        parent::setUp();

        [$this->companyA, $this->companyB] = Company::factory()->count(2)->create();

        // Scoped admin pinned to company A only. Under strict FMCS this
        // actor sees only company A's rows through any Companyable model.
        // For the locations table specifically, whether they can see
        // company B's locations OR null-company locations depends on the
        // scope_locations_fmcs setting.
        $this->scopedActor = $this->companyA->users()->save(User::factory()->make());

        // NOTE: don't actingAs here. Seeding the fixture locations first
        // needs to happen without the fmcs_company validator blocking a
        // non-superuser save under strict FMCS. Each test enables the
        // needed settings, seeds its fixtures WITHOUT an authed user,
        // then swaps to the scoped actor before asserting scope behavior.
    }

    /**
     * Seed a location without going through Watson\ValidatingTrait's
     * fmcs_company validator, which would reject a null-company save
     * under strict FMCS from a non-superuser and prevent the fixture
     * from landing. We are asserting read-side scope behavior; the
     * write-side rule is a separate concern with its own tests. Turn
     * off model-level validation for the seed, then re-enable it.
     */
    private function seedLocation(?int $companyId): Location
    {
        $location = Location::factory()->make();
        $location->company_id = $companyId;
        $location->setValidating(false);
        $location->save();
        $location->setValidating(true);

        return $location->refresh();
    }

    // -----------------------------------------------------------------
    // scope_locations_fmcs OFF: locations are shared across tenants.
    // Every actor sees every location. This is the "opted out of
    // location scoping" configuration many installs run.
    // -----------------------------------------------------------------

    public function test_scoped_actor_sees_null_company_location_when_location_scoping_is_off(): void
    {
        // The customer's exact case: FMCS on, location scoping off,
        // floater off. The scoped actor should still see a location
        // whose Company field is blank.
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();

        $nullCompanyLocation = $this->seedLocation(null);
        $this->actingAs($this->scopedActor);

        $this->assertNotNull(
            Location::find($nullCompanyLocation->id),
            'Location::find() must resolve the null-company location for a scoped actor under scope_locations_fmcs=0.'
        );
    }

    public function test_scoped_actor_sees_other_company_location_when_location_scoping_is_off(): void
    {
        // Regression: with location scoping off, a company A scoped
        // actor should see a location assigned to company B. The
        // "shared locations across tenants" semantic requires it.
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();

        $companyBLocation = $this->seedLocation($this->companyB->id);
        $this->actingAs($this->scopedActor);

        $this->assertNotNull(
            Location::find($companyBLocation->id),
            'Location::find() must resolve a cross-company location for a scoped actor under scope_locations_fmcs=0.'
        );
    }

    public function test_scoped_actor_sees_null_company_location_in_floater_mode_with_scoping_off(): void
    {
        // Floater is orthogonal to scope_locations_fmcs. With scope off,
        // all locations are visible regardless of floater state — no
        // regression on this axis.
        $this->settings->enableFloaterMode();

        $nullCompanyLocation = $this->seedLocation(null);
        $this->actingAs($this->scopedActor);

        $this->assertNotNull(Location::find($nullCompanyLocation->id));
    }

    // -----------------------------------------------------------------
    // scope_locations_fmcs ON: locations are tenant-scoped as before.
    // The scope fires normally, and the pre-existing null-company /
    // floater / pivot-hierarchy behavior kicks in. Regression guards
    // for the strict-scoping path so this fix does not silently open
    // the door on installs that WANT location isolation.
    // -----------------------------------------------------------------

    public function test_scoped_actor_cannot_see_other_company_location_when_location_scoping_is_on(): void
    {
        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();
        $this->settings->disableFloaterMode();

        $companyBLocation = $this->seedLocation($this->companyB->id);
        $this->actingAs($this->scopedActor);

        $this->assertNull(
            Location::find($companyBLocation->id),
            'Under scope_locations_fmcs=1, a scoped actor must not see a cross-company location.'
        );
    }

    public function test_scoped_actor_sees_own_company_location_when_location_scoping_is_on(): void
    {
        // Positive-side regression guard for the strict-scoping path.
        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();
        $this->settings->disableFloaterMode();

        $companyALocation = $this->seedLocation($this->companyA->id);
        $this->actingAs($this->scopedActor);

        $this->assertNotNull(Location::find($companyALocation->id));
    }

    public function test_scoped_actor_cannot_see_null_company_location_in_strict_mode_with_scoping_on(): void
    {
        // scope on + floater off + null-company location = hidden. The
        // pre-fix "null is safe" branch does not apply here; that lives
        // in the action_logs / global-config path, not the locations
        // path.
        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();
        $this->settings->disableFloaterMode();

        $nullCompanyLocation = $this->seedLocation(null);
        $this->actingAs($this->scopedActor);

        $this->assertNull(Location::find($nullCompanyLocation->id));
    }

    public function test_scoped_actor_sees_null_company_location_in_floater_mode_with_scoping_on(): void
    {
        // Floater flips the null-company visibility. Documented behavior.
        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();
        $this->settings->enableFloaterMode();

        $nullCompanyLocation = $this->seedLocation(null);
        $this->actingAs($this->scopedActor);

        $this->assertNotNull(Location::find($nullCompanyLocation->id));
    }

    // -----------------------------------------------------------------
    // Superuser + FMCS-off baseline: not the target of the fix but
    // guards against accidentally over-tightening.
    // -----------------------------------------------------------------

    public function test_superuser_sees_all_locations_regardless_of_setting(): void
    {
        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();
        $this->settings->disableFloaterMode();

        $companyBLocation = $this->seedLocation($this->companyB->id);
        $nullCompanyLocation = $this->seedLocation(null);

        $superuser = User::factory()->superuser()->create();
        $this->actingAs($superuser);

        $this->assertNotNull(Location::find($companyBLocation->id));
        $this->assertNotNull(Location::find($nullCompanyLocation->id));
    }

    public function test_fmcs_off_baseline_all_locations_visible(): void
    {
        // With FMCS entirely off the scope short-circuits at the top
        // of Company::scopeCompanyables. Guard against over-tightening.
        $this->settings->disableMultipleFullCompanySupport();

        $companyBLocation = $this->seedLocation($this->companyB->id);
        $nullCompanyLocation = $this->seedLocation(null);
        $this->actingAs($this->scopedActor);

        $this->assertNotNull(Location::find($companyBLocation->id));
        $this->assertNotNull(Location::find($nullCompanyLocation->id));
    }

    // -----------------------------------------------------------------
    // Cross-model regression guard: the fix must ONLY affect the
    // locations table. Asset / Accessory / etc scoping must be
    // unchanged.
    // -----------------------------------------------------------------

    public function test_other_companyable_models_still_scoped_when_only_location_scoping_is_off(): void
    {
        // scope_locations_fmcs off must not accidentally disable
        // scoping on OTHER companyable tables. Assets in company B
        // should stay hidden from a company A scoped actor.
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();

        $companyBAsset = Asset::factory()->for($this->companyB)->create();
        $this->actingAs($this->scopedActor);

        $this->assertNull(
            Asset::find($companyBAsset->id),
            'scope_locations_fmcs=0 must only affect the locations table; asset scoping must remain intact.'
        );
    }
}
