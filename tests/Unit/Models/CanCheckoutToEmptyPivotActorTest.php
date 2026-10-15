<?php

namespace Tests\Unit\Models;

use App\Models\Asset;
use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

/**
 * GHSA-6hxf-hqrc-wfrp regression coverage for CompanyableTrait::canCheckoutTo.
 *
 * The uncompanied-item branch used $target->companies()->count() === 0 to
 * detect a pivot-less User target. User::companies() is a plain
 * belongsToMany, so the query for the companies table gets the actor's
 * Company::CompanyableScope applied. For an actor with an empty
 * company_user pivot ("null tenant"), that scope reduces the subquery to
 * whereNull('companies.id'), which never matches because companies.id is a
 * NOT NULL primary key. Every target then looked pivot-less, so the strict
 * mode floater deny was flipped to allow for every target regardless of
 * their actual memberships. The fix delegates the User branch to
 * User::canReceiveFromCompany(null), which reads company_user directly via
 * DB::table and avoids the scope trap.
 *
 * These tests pin canCheckoutTo() while acting as an empty-pivot actor,
 * because that is the specific context that triggered the bug. Running the
 * same assertions without actingAs() would pass even against the vulnerable
 * code because there is no actor scope to recurse through.
 */
class CanCheckoutToEmptyPivotActorTest extends TestCase
{
    public function test_empty_pivot_actor_strict_fmcs_blocks_uncompanied_asset_to_companied_user(): void
    {
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();

        $company = Company::factory()->create();
        $companiedTarget = $company->users()->save(User::factory()->create());
        $emptyPivotActor = User::factory()->create();
        $emptyPivotActor->companies()->sync([]);

        $uncompaniedAsset = Asset::factory()->create(['company_id' => null]);

        $this->actingAs($emptyPivotActor);

        $this->assertFalse(
            $uncompaniedAsset->canCheckoutTo($companiedTarget),
            'GHSA-6hxf-hqrc-wfrp: strict FMCS must reject a null-company asset being checked out to a companied user by an empty-pivot actor. The vulnerable code returned true here.'
        );
    }

    public function test_empty_pivot_actor_floater_mode_allows_uncompanied_asset_to_companied_user(): void
    {
        $this->settings->enableFloaterMode();

        $company = Company::factory()->create();
        $companiedTarget = $company->users()->save(User::factory()->create());
        $emptyPivotActor = User::factory()->create();
        $emptyPivotActor->companies()->sync([]);

        $uncompaniedAsset = Asset::factory()->create(['company_id' => null]);

        $this->actingAs($emptyPivotActor);

        $this->assertTrue(
            $uncompaniedAsset->canCheckoutTo($companiedTarget),
            'Floater mode is the setting that legitimately opens null-company items to companied users. The rule must still allow this.'
        );
    }

    public function test_empty_pivot_actor_strict_fmcs_allows_uncompanied_asset_to_empty_pivot_user(): void
    {
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();

        $emptyPivotActor = User::factory()->create();
        $emptyPivotActor->companies()->sync([]);
        $emptyPivotTarget = User::factory()->create();
        $emptyPivotTarget->companies()->sync([]);

        $uncompaniedAsset = Asset::factory()->create(['company_id' => null]);

        $this->actingAs($emptyPivotActor);

        $this->assertTrue(
            $uncompaniedAsset->canCheckoutTo($emptyPivotTarget),
            'Both sides pivot-less is the "null pseudo-company" case that strict FMCS legitimately allows.'
        );
    }

    public function test_companied_actor_strict_fmcs_blocks_uncompanied_asset_to_companied_user_in_other_company(): void
    {
        // Control: the same reject should fire for a companied actor too,
        // and did on the vulnerable code because a companied actor's scope
        // does not degenerate to whereNull('companies.id'). This test is
        // here to guard the fix from over-correcting in the other direction.
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();

        [$acme, $globex] = Company::factory()->count(2)->create();
        $actor = $acme->users()->save(User::factory()->create());
        $companiedTarget = $globex->users()->save(User::factory()->create());

        $uncompaniedAsset = Asset::factory()->create(['company_id' => null]);

        $this->actingAs($actor);

        $this->assertFalse(
            $uncompaniedAsset->canCheckoutTo($companiedTarget),
            'Strict FMCS must still reject a null-company asset to a companied user when the actor is companied too.'
        );
    }
}
