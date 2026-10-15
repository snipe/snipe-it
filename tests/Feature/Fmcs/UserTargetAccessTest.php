<?php

namespace Tests\Feature\Fmcs;

use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

/**
 * Regression coverage for GHSA-j6gg-v2q8-qmgg.
 *
 * The rename of users.company_id to users.legacy_company_id (migration
 * 2026_07_10_000001) silently disabled the User-target branch of
 * Company::isCurrentUserHasAccess() by way of the
 * Schema::hasColumn($table, 'company_id') early-return at the top of the
 * method. hasColumn returned false for every User target and short-
 * circuited the function to `return true` before the per-target check
 * further down could fire. That per-target check exists specifically as
 * the back-patch for the #19187 bypass, so its silent neutering is a
 * defense-in-depth regression.
 *
 * The primary control for User targets is CompanyableScope on User: a
 * standard User::find() through the normal query path filters foreign-
 * company rows at SQL, so the standard controllers never reach the
 * broken policy check. The reachable exposure is a User instance
 * obtained via withoutGlobalScopes() (or via a raw hydration path) and
 * then run through the policy layer. The policy's Company gate must
 * still deny cross-tenant access on its own, independent of whether the
 * query scope filtered it out first.
 *
 * These tests exercise Company::isCurrentUserHasAccess() directly, with
 * a foreign-company User target the caller has explicitly bypassed the
 * global scope to obtain. That is the exact defense-in-depth surface
 * the schema rename opened, and pinning it here prevents any future
 * caller (SCIM sync, an eager-loaded relation, a raw-hydration path)
 * from silently reopening it.
 */
class UserTargetAccessTest extends TestCase
{
    private Company $companyA;

    private Company $companyB;

    protected function setUp(): void
    {
        parent::setUp();

        [$this->companyA, $this->companyB] = Company::factory()->count(2)->create();
    }

    private function assertAccess(bool $expected, $target, string $context): void
    {
        $actual = Company::isCurrentUserHasAccess($target);
        $this->assertSame(
            $expected,
            $actual,
            $context.' (expected '.($expected ? 'ALLOWED' : 'BLOCKED').', got '.($actual ? 'ALLOWED' : 'BLOCKED').')'
        );
    }

    private function actAsCompanyA(): User
    {
        $actor = $this->companyA->users()->save(User::factory()->make());
        $this->actingAs($actor);

        return $actor;
    }

    private function crossCompanyUserFetchedUnscoped(Company $company): User
    {
        $target = $company->users()->save(User::factory()->make());

        // The reachable surface: a caller that bypasses CompanyableScope to
        // obtain a foreign-company User (SCIM path, eager relation loaded
        // withoutGlobalScopes(), raw hydration) and then hands the object
        // to the policy layer.
        return User::withoutGlobalScopes()->find($target->id);
    }

    // -----------------------------------------------------------------
    // FMCS off. The gate short-circuits to true regardless, so cross-
    // company User targets are ALLOWED. This is baseline non-FMCS
    // behavior and must not regress.
    // -----------------------------------------------------------------

    public function test_fmcs_off_cross_company_user_target_allowed(): void
    {
        $this->settings->disableMultipleFullCompanySupport();
        $this->actAsCompanyA();

        $target = $this->crossCompanyUserFetchedUnscoped($this->companyB);

        $this->assertAccess(true, $target, 'FMCS off, Company A actor, cross-company User target');
    }

    // -----------------------------------------------------------------
    // FMCS on, STRICT (floater off).
    //
    // A Company A actor must not be able to authorize on a Company B
    // User instance, even when that instance was obtained via
    // withoutGlobalScopes() (i.e. the query scope did not filter it out).
    // This is the exact GHSA-j6gg-v2q8-qmgg surface.
    // -----------------------------------------------------------------

    public function test_strict_actor_blocked_from_cross_company_user_target(): void
    {
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();
        $this->actAsCompanyA();

        $target = $this->crossCompanyUserFetchedUnscoped($this->companyB);

        $this->assertAccess(false, $target, 'Strict FMCS, Company A actor, cross-company User via withoutGlobalScopes');
    }

    public function test_strict_actor_allowed_own_company_user_target(): void
    {
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();
        $this->actAsCompanyA();

        $target = $this->companyA->users()->save(User::factory()->make());

        $this->assertAccess(true, $target, 'Strict FMCS, Company A actor, in-company User target');
    }

    // -----------------------------------------------------------------
    // FMCS on, FLOATER MODE.
    //
    // Floater semantics on Users mirror the User scope: null-pivot
    // Users are floaters (visible to everyone), and a company-scoped
    // caller sees their own pivot + floaters. A pivoted-to-Company-B
    // target is not visible to a Company A caller under floater either.
    // -----------------------------------------------------------------

    public function test_floater_actor_blocked_from_cross_company_user_target(): void
    {
        $this->settings->enableFloaterMode();
        $this->actAsCompanyA();

        $target = $this->crossCompanyUserFetchedUnscoped($this->companyB);

        $this->assertAccess(false, $target, 'Floater FMCS, Company A actor, cross-company User via withoutGlobalScopes');
    }

    public function test_floater_actor_allowed_null_pivot_user_target(): void
    {
        $this->settings->enableFloaterMode();
        $this->actAsCompanyA();

        $target = User::factory()->create();
        $target->companies()->sync([]);

        $this->assertAccess(true, $target, 'Floater FMCS, Company A actor, null-pivot User target should be a floater');
    }

    // -----------------------------------------------------------------
    // Regression guards. Superuser bypass and unauthenticated behavior
    // must be untouched by the User-target hasColumn fix.
    // -----------------------------------------------------------------

    public function test_superuser_bypasses_gate_for_cross_company_user_target(): void
    {
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();

        $superuser = User::factory()->superuser()->create();
        $this->actingAs($superuser);

        $target = $this->crossCompanyUserFetchedUnscoped($this->companyB);

        $this->assertAccess(true, $target, 'Superusers bypass FMCS unconditionally, including for User targets');
    }

    public function test_unauthenticated_denied_for_user_target(): void
    {
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();

        $target = $this->companyB->users()->save(User::factory()->make());

        $this->assertAccess(false, $target, 'Unauthenticated request, User target must be denied');
    }
}
