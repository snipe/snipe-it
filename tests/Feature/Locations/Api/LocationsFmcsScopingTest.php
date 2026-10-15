<?php

namespace Tests\Feature\Locations\Api;

use App\Models\Company;
use App\Models\Location;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Verifies FMCS scoping rules for the location index and selectlist endpoints.
 *
 * Location scoping under FMCS is opt-in via the scope_locations_fmcs
 * setting. That setting is off by default (has been since it was added
 * in 2023_02_27_092130_add_scope_locations_setting), which reflects the
 * install-time reality that most installs want Locations shared across
 * tenants. Company::scopeCompanyablesDirectly() honors the setting for
 * the locations table so read-side scope semantics match the write-side
 * gate on LocationsController::store and the checkout-time gate in
 * CompanyableTrait::canCheckoutTo() (both of which have honored the
 * setting since they were added).
 *
 * Rules under test:
 *  1. FMCS OFF → all locations visible to any authorized user (baseline)
 *  2. FMCS ON, scope_locations_fmcs OFF → all locations visible regardless of company
 *  3. FMCS ON, scope_locations_fmcs ON, user has companies → only same-company locations visible
 *  4. FMCS ON, scope_locations_fmcs ON, user has companies → null-company locations NOT visible
 *  5. FMCS ON, scope_locations_fmcs ON, user has NO companies → only null-company locations visible
 *  6. FMCS ON, scope_locations_fmcs ON, user has NO companies → company-scoped locations NOT visible
 *
 * Rules 3-6 gate on scope_locations_fmcs = 1 because opting into
 * location scoping under FMCS is what enables tenant isolation for the
 * locations table. Without it, Snipe-IT treats locations as global
 * config records shared across every tenant.
 */
class LocationsFmcsScopingTest extends TestCase
{
    // -----------------------------------------------------------------------
    // Helpers
    // -----------------------------------------------------------------------

    private function userInCompany(Company $company): User
    {
        $user = User::factory()->viewLocationHistory()->createUsers()->create();
        DB::table('company_user')->insert([
            'company_id' => $company->id,
            'user_id' => $user->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $user;
    }

    private function userWithNoCompany(): User
    {
        return User::factory()->viewLocationHistory()->createUsers()->withoutCompany()->create();
    }

    private function indexIds(User $user): array
    {
        return collect(
            $this->actingAsForApi($user)
                ->getJson(route('api.locations.index', ['limit' => 500]))
                ->assertOk()
                ->json('rows')
        )->pluck('id')->all();
    }

    private function selectlistIds(User $user): array
    {
        return collect(
            $this->actingAsForApi($user)
                ->getJson(route('api.locations.selectlist', ['limit' => 500]))
                ->assertOk()
                ->json('results')
        )->pluck('id')->all();
    }

    // -----------------------------------------------------------------------
    // FMCS OFF (baseline)
    // -----------------------------------------------------------------------

    public function test_fmcs_off_user_sees_all_locations_on_index()
    {
        $this->settings->disableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $locationA = Location::factory()->create(['company_id' => $companyA->id]);
        $locationB = Location::factory()->create(['company_id' => $companyB->id]);
        $locationNull = Location::factory()->create(['company_id' => null]);

        $user = $this->userInCompany($companyA);
        $ids = $this->indexIds($user);

        $this->assertContains($locationA->id, $ids, 'Own-company location should be visible');
        $this->assertContains($locationB->id, $ids, 'Other-company location should be visible when FMCS off');
        $this->assertContains($locationNull->id, $ids, 'Null-company location should be visible when FMCS off');
    }

    public function test_fmcs_off_user_sees_all_locations_on_selectlist()
    {
        $this->settings->disableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $locationA = Location::factory()->create(['company_id' => $companyA->id]);
        $locationB = Location::factory()->create(['company_id' => $companyB->id]);
        $locationNull = Location::factory()->create(['company_id' => null]);

        $user = $this->userInCompany($companyA);
        $ids = $this->selectlistIds($user);

        $this->assertContains($locationA->id, $ids, 'Own-company location should be in selectlist');
        $this->assertContains($locationB->id, $ids, 'Other-company location should be in selectlist when FMCS off');
        $this->assertContains($locationNull->id, $ids, 'Null-company location should be in selectlist when FMCS off');
    }

    // -----------------------------------------------------------------------
    // FMCS ON, scope_locations_fmcs OFF (default) — locations stay shared
    // -----------------------------------------------------------------------

    public function test_fmcs_on_location_scoping_off_user_sees_all_locations_on_index()
    {
        // The customer FD-57180 configuration: FMCS on, location scoping
        // off, floater off. All locations must be visible to a scoped
        // admin because they've opted out of location-level tenant
        // isolation via the setting.
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $locationA = Location::factory()->create(['company_id' => $companyA->id]);
        $locationB = Location::factory()->create(['company_id' => $companyB->id]);
        $locationNull = Location::factory()->create(['company_id' => null]);

        $user = $this->userInCompany($companyA);
        $ids = $this->indexIds($user);

        $this->assertContains($locationA->id, $ids, 'Own-company location should be visible');
        $this->assertContains($locationB->id, $ids, 'Other-company location should be visible when scope_locations_fmcs off');
        $this->assertContains($locationNull->id, $ids, 'Null-company location should be visible when scope_locations_fmcs off');
    }

    public function test_fmcs_on_location_scoping_off_user_sees_all_locations_on_selectlist()
    {
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $locationA = Location::factory()->create(['company_id' => $companyA->id]);
        $locationB = Location::factory()->create(['company_id' => $companyB->id]);
        $locationNull = Location::factory()->create(['company_id' => null]);

        $user = $this->userInCompany($companyA);
        $ids = $this->selectlistIds($user);

        $this->assertContains($locationA->id, $ids, 'Own-company location should be in selectlist');
        $this->assertContains($locationB->id, $ids, 'Other-company location should be in selectlist when scope_locations_fmcs off');
        $this->assertContains($locationNull->id, $ids, 'Null-company location should be in selectlist when scope_locations_fmcs off');
    }

    // -----------------------------------------------------------------------
    // FMCS ON, scope_locations_fmcs ON — user WITH companies
    // -----------------------------------------------------------------------

    public function test_fmcs_on_user_with_company_sees_own_company_location_on_index()
    {
        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();

        $company = Company::factory()->create();
        $location = Location::factory()->create(['company_id' => $company->id]);
        $user = $this->userInCompany($company);

        $this->assertContains($location->id, $this->indexIds($user),
            'Location in same company should be visible');
    }

    public function test_fmcs_on_user_with_company_cannot_see_other_company_location_on_index()
    {
        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $locationB = Location::factory()->create(['company_id' => $companyB->id]);
        $user = $this->userInCompany($companyA);

        $this->assertNotContains($locationB->id, $this->indexIds($user),
            'Location in a different company should not be visible');
    }

    public function test_fmcs_on_user_with_company_cannot_see_null_company_location_on_index()
    {
        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();
        $this->settings->disableFloaterMode();

        $company = Company::factory()->create();
        $locationNull = Location::factory()->create(['company_id' => null]);
        $user = $this->userInCompany($company);

        $this->assertNotContains($locationNull->id, $this->indexIds($user),
            'Location with no company should not be visible to company-scoped user in strict mode');
    }

    public function test_fmcs_on_user_with_company_sees_own_company_location_on_selectlist()
    {
        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();

        $company = Company::factory()->create();
        $location = Location::factory()->create(['company_id' => $company->id]);
        $user = $this->userInCompany($company);

        $this->assertContains($location->id, $this->selectlistIds($user),
            'Location in same company should appear in selectlist');
    }

    public function test_fmcs_on_user_with_company_cannot_see_other_company_location_on_selectlist()
    {
        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $locationB = Location::factory()->create(['company_id' => $companyB->id]);
        $user = $this->userInCompany($companyA);

        $this->assertNotContains($locationB->id, $this->selectlistIds($user),
            'Location in a different company should not appear in selectlist');
    }

    public function test_fmcs_on_user_with_company_cannot_see_null_company_location_on_selectlist()
    {
        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();
        $this->settings->disableFloaterMode();

        $company = Company::factory()->create();
        $locationNull = Location::factory()->create(['company_id' => null]);
        $user = $this->userInCompany($company);

        $this->assertNotContains($locationNull->id, $this->selectlistIds($user),
            'Location with no company should not appear in selectlist for company-scoped user in strict mode');
    }

    // -----------------------------------------------------------------------
    // FMCS ON, scope_locations_fmcs ON — user with NO companies
    // -----------------------------------------------------------------------

    public function test_fmcs_on_user_with_no_company_sees_null_company_locations_on_index()
    {
        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();
        $this->settings->disableFloaterMode();

        $locationNull = Location::factory()->create(['company_id' => null]);
        $user = $this->userWithNoCompany();

        $this->assertContains($locationNull->id, $this->indexIds($user),
            'Location with no company should be visible to user with no company');
    }

    public function test_fmcs_on_user_with_no_company_cannot_see_company_locations_on_index()
    {
        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();
        $this->settings->disableFloaterMode();

        $company = Company::factory()->create();
        $location = Location::factory()->create(['company_id' => $company->id]);
        $user = $this->userWithNoCompany();

        $this->assertNotContains($location->id, $this->indexIds($user),
            'Location with a company should not be visible to user with no company');
    }

    public function test_fmcs_on_user_with_no_company_sees_null_company_locations_on_selectlist()
    {
        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();
        $this->settings->disableFloaterMode();

        $locationNull = Location::factory()->create(['company_id' => null]);
        $user = $this->userWithNoCompany();

        $this->assertContains($locationNull->id, $this->selectlistIds($user),
            'Location with no company should appear in selectlist for user with no company');
    }

    public function test_fmcs_on_user_with_no_company_cannot_see_company_locations_on_selectlist()
    {
        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();
        $this->settings->disableFloaterMode();

        $company = Company::factory()->create();
        $location = Location::factory()->create(['company_id' => $company->id]);
        $user = $this->userWithNoCompany();

        $this->assertNotContains($location->id, $this->selectlistIds($user),
            'Location with a company should not appear in selectlist for user with no company');
    }
}
