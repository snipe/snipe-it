<?php

namespace Tests\Unit;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\Company;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\Department;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\Maintenance;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CompanyScopingTest extends TestCase
{
    /**
     * Every companyable model that stores its own company_id on a real
     * column AND is unconditionally tenant-scoped under FMCS. Adding a
     * model to this list runs the whole DataProvider matrix against it.
     *
     * Users are covered by test_user_scoping_matrix (pivot semantics).
     * Company, Actionlog, and ConsumableAssignment are companyable but
     * not first-class list targets so they're out of scope for the
     * provider matrix.
     *
     * Location is DELIBERATELY excluded: location scoping under FMCS is
     * opt-in via the scope_locations_fmcs setting (off by default), so
     * Location does not share the same strict/floater matrix as the
     * always-scoped models. Location's own coverage lives in
     * tests/Feature/Fmcs/LocationScopingSettingTest.php and
     * tests/Feature/Locations/Api/LocationsFmcsScopingTest.php.
     */
    public static function models(): array
    {
        return [
            'Accessories' => [Accessory::class],
            'Assets' => [Asset::class],
            'Components' => [Component::class],
            'Consumables' => [Consumable::class],
            'Departments' => [Department::class],
            'Licenses' => [License::class],
        ];
    }

    #[DataProvider('models')]
    public function test_company_scoping($model)
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $modelA = $model::factory()->for($companyA)->create();
        $modelB = $model::factory()->for($companyB)->create();

        $superUser = $companyA->users()->save(User::factory()->superuser()->make());
        $userInCompanyA = $companyA->users()->save(User::factory()->make());
        $userInCompanyB = $companyB->users()->save(User::factory()->make());

        $this->settings->disableMultipleFullCompanySupport();

        $this->actingAs($superUser);
        $this->assertCanSee($modelA);
        $this->assertCanSee($modelB);

        $this->actingAs($userInCompanyA);
        $this->assertCanSee($modelA);
        $this->assertCanSee($modelB);

        $this->actingAs($userInCompanyB);
        $this->assertCanSee($modelA);
        $this->assertCanSee($modelB);

        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAs($superUser);
        $this->assertCanSee($modelA);
        $this->assertCanSee($modelB);

        $this->actingAs($userInCompanyA);
        $this->assertCanSee($modelA);
        $this->assertCannotSee($modelB);

        $this->actingAs($userInCompanyB);
        $this->assertCannotSee($modelA);
        $this->assertCanSee($modelB);
    }

    public function test_maintenance_company_scoping()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $maintenanceForCompanyA = Maintenance::factory()->for(Asset::factory()->for($companyA))->create();
        $maintenanceForCompanyB = Maintenance::factory()->for(Asset::factory()->for($companyB))->create();

        $superUser = $companyA->users()->save(User::factory()->superuser()->make());
        $userInCompanyA = $companyA->users()->save(User::factory()->make());
        $userInCompanyB = $companyB->users()->save(User::factory()->make());

        $this->settings->disableMultipleFullCompanySupport();

        $this->actingAs($superUser);
        $this->assertCanSee($maintenanceForCompanyA);
        $this->assertCanSee($maintenanceForCompanyB);

        $this->actingAs($userInCompanyA);
        $this->assertCanSee($maintenanceForCompanyA);
        $this->assertCanSee($maintenanceForCompanyB);

        $this->actingAs($userInCompanyB);
        $this->assertCanSee($maintenanceForCompanyA);
        $this->assertCanSee($maintenanceForCompanyB);

        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAs($superUser);
        $this->assertCanSee($maintenanceForCompanyA);
        $this->assertCanSee($maintenanceForCompanyB);

        $this->actingAs($userInCompanyA);
        $this->assertCanSee($maintenanceForCompanyA);
        $this->assertCannotSee($maintenanceForCompanyB);

        $this->actingAs($userInCompanyB);
        $this->assertCannotSee($maintenanceForCompanyA);
        $this->assertCanSee($maintenanceForCompanyB);
    }

    public function test_license_seat_company_scoping()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $licenseSeatA = LicenseSeat::factory()->for(Asset::factory()->for($companyA))->create();
        $licenseSeatB = LicenseSeat::factory()->for(Asset::factory()->for($companyB))->create();

        $superUser = $companyA->users()->save(User::factory()->superuser()->make());
        $userInCompanyA = $companyA->users()->save(User::factory()->make());
        $userInCompanyB = $companyB->users()->save(User::factory()->make());

        $this->settings->disableMultipleFullCompanySupport();

        $this->actingAs($superUser);
        $this->assertCanSee($licenseSeatA);
        $this->assertCanSee($licenseSeatB);

        $this->actingAs($userInCompanyA);
        $this->assertCanSee($licenseSeatA);
        $this->assertCanSee($licenseSeatB);

        $this->actingAs($userInCompanyB);
        $this->assertCanSee($licenseSeatA);
        $this->assertCanSee($licenseSeatB);

        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAs($superUser);
        $this->assertCanSee($licenseSeatA);
        $this->assertCanSee($licenseSeatB);

        $this->actingAs($userInCompanyA);
        $this->assertCanSee($licenseSeatA);
        $this->assertCannotSee($licenseSeatB);

        $this->actingAs($userInCompanyB);
        $this->assertCannotSee($licenseSeatA);
        $this->assertCanSee($licenseSeatB);
    }

    #[DataProvider('models')]
    public function test_company_user_cannot_see_null_company_items_in_strict_mode($model)
    {
        $company = Company::factory()->create();
        $nullCompanyItem = $model::factory()->create(['company_id' => null]);
        $companyItem = $model::factory()->for($company)->create();
        $companyUser = $company->users()->save(User::factory()->make());

        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAs($companyUser);
        $this->assertCannotSee($nullCompanyItem);
        $this->assertCanSee($companyItem);
    }

    #[DataProvider('models')]
    public function test_company_user_can_see_null_company_items_in_floater_mode($model)
    {
        $company = Company::factory()->create();
        $nullCompanyItem = $model::factory()->create(['company_id' => null]);
        $companyItem = $model::factory()->for($company)->create();
        $companyUser = $company->users()->save(User::factory()->make());

        $this->settings->enableFloaterMode();

        $this->actingAs($companyUser);
        $this->assertCanSee($nullCompanyItem);
        $this->assertCanSee($companyItem);
    }

    #[DataProvider('models')]
    public function test_null_company_user_cannot_see_company_items_in_strict_mode($model)
    {
        $company = Company::factory()->create();
        $nullCompanyItem = $model::factory()->create(['company_id' => null]);
        $companyItem = $model::factory()->for($company)->create();
        $nullCompanyUser = User::factory()->withoutCompany()->create();

        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAs($nullCompanyUser);
        $this->assertCanSee($nullCompanyItem);
        $this->assertCannotSee($companyItem);
    }

    #[DataProvider('models')]
    public function test_null_company_user_can_see_all_items_in_floater_mode($model)
    {
        $company = Company::factory()->create();
        $nullCompanyItem = $model::factory()->create(['company_id' => null]);
        $companyItem = $model::factory()->for($company)->create();
        $nullCompanyUser = User::factory()->withoutCompany()->create();

        $this->settings->enableFloaterMode();

        $this->actingAs($nullCompanyUser);
        $this->assertCanSee($nullCompanyItem);
        $this->assertCanSee($companyItem);
    }

    /**
     * FMCS + floaters on: null-company users are visible to a
     * company-scoped caller. This mirrors the item-level floater rule
     * documented at https://snipe-it.readme.io/docs/multi-tenancy-ish and
     * is required so checkout dropdowns can offer floater users as valid
     * targets under the "items from any company can be checked out to
     * targets with no company assignment" policy.
     */
    public function test_company_scoped_user_can_see_null_company_users_in_floater_mode()
    {
        $company = Company::factory()->create();
        $companyUser = $company->users()->save(User::factory()->make());
        $nullCompanyUser = User::factory()->withoutCompany()->create();

        $this->settings->enableFloaterMode();

        $this->actingAs($companyUser);
        $this->assertCanSee($nullCompanyUser);
    }

    public function test_company_scoped_user_cannot_see_null_company_users_in_strict_mode()
    {
        $company = Company::factory()->create();
        $companyUser = $company->users()->save(User::factory()->make());
        $nullCompanyUser = User::factory()->withoutCompany()->create();

        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAs($companyUser);
        $this->assertCannotSee($nullCompanyUser);
    }

    /**
     * Floater callers are unrestricted, so they see everyone (their own
     * kind and every company-scoped user). Superuser bypass is handled
     * upstream in scopeCompanyables.
     */
    public function test_null_company_user_can_see_null_company_users_in_floater_mode()
    {
        $company = Company::factory()->create();
        $companyUser = $company->users()->save(User::factory()->make());
        $nullCompanyCaller = User::factory()->withoutCompany()->create();
        $anotherNullCompanyUser = User::factory()->withoutCompany()->create();

        $this->settings->enableFloaterMode();

        $this->actingAs($nullCompanyCaller);
        $this->assertCanSee($anotherNullCompanyUser);
        $this->assertCanSee($companyUser);
    }

    /**
     * Regression pin for support ticket 56305. A company A caller under
     * FMCS + floater mode sees users in their own pivot companies AND
     * null-company (floater) users, but NEVER users pivoted only to
     * OTHER companies. Root cause of the ticket was that
     * `orWhereDoesntHave('companies')` in the floater branch had the
     * companies-table CompanyableScope applied recursively to its
     * subquery, so a user pivoted only to out-of-scope companies looked
     * pivot-less and slipped through as an apparent floater. Fix reads
     * the company_user pivot directly (see Company.php around line 610).
     */
    public function test_company_scoped_user_cannot_see_other_companies_users_in_floater_mode()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $companyACaller = $companyA->users()->save(User::factory()->make());
        $companyAPeer = $companyA->users()->save(User::factory()->make());
        $companyBUser = $companyB->users()->save(User::factory()->make());
        $floaterUser = User::factory()->withoutCompany()->create();

        $this->settings->enableFloaterMode();

        $this->actingAs($companyACaller);
        $this->assertCanSee($companyAPeer);
        $this->assertCanSee($floaterUser);
        $this->assertCannotSee($companyBUser);
    }

    /**
     * Adversarial matrix for User scoping. Users use pivot semantics
     * (company_user) rather than a company_id column, so the item-oriented
     * DataProvider tests above don't cover them. This method exercises
     * every caller x FMCS mode combination so any recursive-scope leak or
     * policy drift lights up here rather than in production. See the
     * "FMCS changes require adversarial cross-company negative tests"
     * memory rule for the checklist that produced this.
     *
     * Callers:
     *   - company-scoped non-superuser
     *   - null-company non-superuser (floater caller)
     *   - superuser
     * Modes:
     *   - FMCS off
     *   - FMCS on, floater off (strict)
     *   - FMCS on, floater on
     */
    public function test_user_scoping_matrix()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $superuser = $companyA->users()->save(User::factory()->superuser()->make());
        $callerInA = $companyA->users()->save(User::factory()->make());
        $callerFloater = User::factory()->withoutCompany()->create();
        $peerInA = $companyA->users()->save(User::factory()->make());
        $userInB = $companyB->users()->save(User::factory()->make());
        $floater = User::factory()->withoutCompany()->create();

        // FMCS off: everyone sees everyone regardless of caller.
        $this->settings->disableMultipleFullCompanySupport();

        foreach ([$superuser, $callerInA, $callerFloater] as $caller) {
            $this->actingAs($caller);
            Company::flushCompanyIdsCache();
            $this->assertCanSee($peerInA);
            $this->assertCanSee($userInB);
            $this->assertCanSee($floater);
        }

        // FMCS on, floater off (strict): company-scoped caller sees only
        // their pivot companies. Floater caller sees only other floaters.
        // Superuser sees everyone.
        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAs($superuser);
        Company::flushCompanyIdsCache();
        $this->assertCanSee($peerInA);
        $this->assertCanSee($userInB);
        $this->assertCanSee($floater);

        $this->actingAs($callerInA);
        Company::flushCompanyIdsCache();
        $this->assertCanSee($peerInA);
        $this->assertCannotSee($userInB);
        $this->assertCannotSee($floater);

        $this->actingAs($callerFloater);
        Company::flushCompanyIdsCache();
        $this->assertCannotSee($peerInA);
        $this->assertCannotSee($userInB);
        $this->assertCanSee($floater);

        // FMCS on, floater on: company-scoped caller sees their own pivot
        // companies AND null-company (floater) users, matching the docs at
        // https://snipe-it.readme.io/docs/multi-tenancy-ish. They still do
        // NOT see users pivoted to other companies (that was the ticket 56305
        // regression). Floater caller sees everyone. Superuser sees everyone.
        $this->settings->enableFloaterMode();

        $this->actingAs($superuser);
        Company::flushCompanyIdsCache();
        $this->assertCanSee($peerInA);
        $this->assertCanSee($userInB);
        $this->assertCanSee($floater);

        $this->actingAs($callerInA);
        Company::flushCompanyIdsCache();
        $this->assertCanSee($peerInA);
        $this->assertCannotSee($userInB);
        $this->assertCanSee($floater);

        // A floater caller is "unrestricted" and sees everyone.
        $this->actingAs($callerFloater);
        Company::flushCompanyIdsCache();
        $this->assertCanSee($peerInA);
        $this->assertCanSee($userInB);
        $this->assertCanSee($floater);
    }

    private function assertCanSee(Model $model)
    {
        $this->assertTrue(
            get_class($model)::all()->contains($model),
            'User was not able to see expected model'
        );
    }

    private function assertCannotSee(Model $model)
    {
        $this->assertFalse(
            get_class($model)::all()->contains($model),
            'User was able to see model from a different company'
        );
    }
}
