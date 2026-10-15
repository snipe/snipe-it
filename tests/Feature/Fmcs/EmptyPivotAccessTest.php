<?php

namespace Tests\Feature\Fmcs;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\Company;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\License;
use App\Models\User;
use Tests\TestCase;

/**
 * Regression coverage for GHSA-8hq6-r8cw-gqwh.
 *
 * Company::isCurrentUserHasAccess() historically returned true
 * unconditionally for any actor whose company_user pivot was empty. The
 * intent was to preserve legacy behavior for pre-FMCS users who never
 * had a company_id set (or, post-migration, no pivot rows), but the
 * effect was that any non-superuser with role permissions could be
 * created with no pivot rows and get UNRESTRICTED per-target access to
 * every companyable in every tenant on the install — a full FMCS bypass
 * for that actor.
 *
 * The query-scope side of the code already handled empty-pivot actors
 * correctly:
 *   - Strict mode: empty pivot sees only null-company items (nothing,
 *     effectively, since production items usually have a company_id).
 *   - Floater mode: empty pivot is treated as "floater" and sees all
 *     items (documented behavior at snipe-it.readme.io/docs/multi-tenancy-ish).
 *
 * The fix aligns isCurrentUserHasAccess() branch-for-branch with the
 * query scope for companyable items, so per-target policy checks match
 * list visibility:
 *   - Floater ON: allowed (mirrors `return $query`).
 *   - Floater OFF: allowed only for null-company items (mirrors
 *     `whereNull($column)`).
 *
 * Scope note: Company targets are NOT covered here. The tables-without-
 * a-company_id-column early exit at the top of isCurrentUserHasAccess()
 * short-circuits every Company / Location / etc. target to `return true`
 * for every actor (empty pivot or not, superuser or not). That predates
 * this GHSA and is a separate surface; tightening it belongs in its own
 * advisory / fix.
 *
 * These tests exercise the direct API surface. FMCS query-scope tests
 * are in tests/Feature/Fmcs/HttpCrossCompanyLeakTest.php and its
 * siblings; that suite continues to gate list visibility. This file
 * gates per-target authorization, which is the branch the GHSA hit.
 */
class EmptyPivotAccessTest extends TestCase
{
    private User $emptyPivotActor;

    private Company $companyA;

    private Company $companyB;

    protected function setUp(): void
    {
        parent::setUp();

        [$this->companyA, $this->companyB] = Company::factory()->count(2)->create();

        // The actor's pivot is deliberately left empty. Role permissions
        // are broad enough that the SnipePermissionsPolicy would grant
        // authorization on any item; the FMCS gate we're testing is what
        // stops them from acting on cross-tenant rows.
        $this->emptyPivotActor = User::factory()->create();
        $this->emptyPivotActor->companies()->sync([]);

        $this->actingAs($this->emptyPivotActor);
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

    // -----------------------------------------------------------------
    // FMCS OFF baseline. Empty-pivot access must not regress here, since
    // the whole gate collapses to "everyone sees everything" without FMCS.
    // -----------------------------------------------------------------

    public function test_fmcs_off_empty_pivot_can_access_any_asset(): void
    {
        $this->settings->disableMultipleFullCompanySupport();
        $companyBAsset = Asset::factory()->for($this->companyB)->create();

        $this->assertAccess(true, $companyBAsset, 'FMCS off, empty pivot, cross-company Asset');
    }

    // -----------------------------------------------------------------
    // FMCS on, STRICT (floater off).
    //
    // Empty pivot actor must NOT be able to act on any company's rows,
    // and must NOT be able to act on Company targets at all. Their only
    // legitimate access surface is null-company items.
    // -----------------------------------------------------------------

    public function test_strict_empty_pivot_cannot_access_asset_in_any_company(): void
    {
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();
        $asset = Asset::factory()->for($this->companyB)->create();

        $this->assertAccess(false, $asset, 'Strict FMCS, empty pivot, Asset in company B — cross-tenant leak (GHSA-8hq6-r8cw-gqwh).');
    }

    public function test_strict_empty_pivot_cannot_access_accessory_in_any_company(): void
    {
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();
        $accessory = Accessory::factory()->for($this->companyB)->create();

        $this->assertAccess(false, $accessory, 'Strict FMCS, empty pivot, Accessory in company B');
    }

    public function test_strict_empty_pivot_cannot_access_consumable_in_any_company(): void
    {
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();
        $consumable = Consumable::factory()->for($this->companyB)->create();

        $this->assertAccess(false, $consumable, 'Strict FMCS, empty pivot, Consumable in company B');
    }

    public function test_strict_empty_pivot_cannot_access_component_in_any_company(): void
    {
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();
        $component = Component::factory()->for($this->companyB)->create();

        $this->assertAccess(false, $component, 'Strict FMCS, empty pivot, Component in company B');
    }

    public function test_strict_empty_pivot_cannot_access_license_in_any_company(): void
    {
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();
        $license = License::factory()->for($this->companyB)->create();

        $this->assertAccess(false, $license, 'Strict FMCS, empty pivot, License in company B');
    }

    public function test_strict_empty_pivot_can_still_access_null_company_asset(): void
    {
        // Positive regression: strict mode is not "block everything".
        // Null-company items are the one legitimate surface an empty-
        // pivot actor is intended to see (matches the query scope's
        // `whereNull($column)` branch for empty pivot in strict).
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();
        $nullAsset = Asset::factory()->create(['company_id' => null]);

        $this->assertAccess(true, $nullAsset, 'Strict FMCS, empty pivot, null-company Asset should be visible.');
    }

    // -----------------------------------------------------------------
    // FMCS on, FLOATER MODE.
    //
    // In floater mode empty-pivot actors ARE unrestricted for items
    // (mirrors `return $query` in the query scope). This is documented
    // behavior at snipe-it.readme.io/docs/multi-tenancy-ish — a "floater"
    // actor is intentionally not company-scoped.
    // -----------------------------------------------------------------

    public function test_floater_empty_pivot_can_access_asset_in_any_company(): void
    {
        $this->settings->enableFloaterMode();
        $asset = Asset::factory()->for($this->companyB)->create();

        $this->assertAccess(true, $asset, 'Floater FMCS, empty pivot, cross-company Asset should be accessible (matches query scope).');
    }

    public function test_floater_empty_pivot_can_access_accessory_in_any_company(): void
    {
        $this->settings->enableFloaterMode();
        $accessory = Accessory::factory()->for($this->companyB)->create();

        $this->assertAccess(true, $accessory, 'Floater FMCS, empty pivot, cross-company Accessory');
    }

    public function test_floater_empty_pivot_can_access_null_company_asset(): void
    {
        $this->settings->enableFloaterMode();
        $nullAsset = Asset::factory()->create(['company_id' => null]);

        $this->assertAccess(true, $nullAsset, 'Floater FMCS, empty pivot, null-company Asset');
    }

    // -----------------------------------------------------------------
    // Regression guards: superuser and non-empty pivot behavior must be
    // untouched by the empty-pivot fix.
    // -----------------------------------------------------------------

    public function test_superuser_with_empty_pivot_still_bypasses_fmcs(): void
    {
        $superuser = User::factory()->superuser()->create();
        $superuser->companies()->sync([]);
        $this->actingAs($superuser);

        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();

        $asset = Asset::factory()->for($this->companyB)->create();

        $this->assertAccess(true, $asset, 'Superusers bypass FMCS unconditionally, empty pivot or not.');
    }

    public function test_non_empty_pivot_actor_still_scoped_to_their_companies(): void
    {
        $companyAActor = $this->companyA->users()->save(User::factory()->make());
        $this->actingAs($companyAActor);

        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();

        $inCompanyAsset = Asset::factory()->for($this->companyA)->create();
        $crossCompanyAsset = Asset::factory()->for($this->companyB)->create();

        $this->assertAccess(true, $inCompanyAsset, 'Company A actor, in-company Asset');
        $this->assertAccess(false, $crossCompanyAsset, 'Company A actor, cross-company Asset');
    }
}
