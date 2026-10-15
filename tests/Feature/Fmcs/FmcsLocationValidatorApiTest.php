<?php

namespace Tests\Feature\Fmcs;

use App\Models\Asset;
use App\Models\Company;
use App\Models\Location;
use App\Models\User;
use Tests\TestCase;

/**
 * End-to-end coverage for the `fmcs_location` validator's write-side
 * behavior when `scope_locations_fmcs=1` is on.
 *
 * The validator lives in `ValidationServiceProvider` and gates every
 * `location_id` write on Asset / Accessory / Consumable / Component
 * (declared on the model's `$rules`). The Asset API checkin path is
 * the highest-traffic write and is exercised here as the representative
 * case; adding sibling coverage for accessory / consumable / component
 * writes would be pure duplication of the same rule.
 *
 * The scenarios pin the invariant that under strict location scoping a
 * scoped actor cannot write a cross-tenant `location_id` onto an asset
 * they otherwise have permission to check in. The `fmcs_location`
 * lookup must bypass CompanyableScope so foreign locations resolve for
 * comparison rather than falling through as "not found" and passing
 * validation.
 */
class FmcsLocationValidatorApiTest extends TestCase
{
    public function test_scope_locations_fmcs_on_blocks_api_checkin_to_cross_company_location(): void
    {
        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();
        $this->settings->disableFloaterMode();

        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $actor = $companyA->users()->save(User::factory()->checkinAssets()->make());

        $companyALocation = Location::factory()->make();
        $companyALocation->company_id = $companyA->id;
        $companyALocation->setValidating(false);
        $companyALocation->save();

        $companyBLocation = Location::factory()->make();
        $companyBLocation->company_id = $companyB->id;
        $companyBLocation->setValidating(false);
        $companyBLocation->save();

        $target = $companyA->users()->save(User::factory()->make());
        $asset = Asset::factory()
            ->for($companyA)
            ->assignedToUser($target)
            ->create([
                'location_id' => $companyALocation->id,
                'rtd_location_id' => $companyALocation->id,
            ]);

        $this->actingAsForApi($actor)
            ->postJson(route('api.asset.checkin', $asset->id), [
                'location_id' => $companyBLocation->id,
            ])
            ->assertStatusMessageIs('error');

        $this->assertSame(
            $companyALocation->id,
            (int) $asset->fresh()->location_id,
            'Asset location_id must not be re-parented onto a cross-company location under strict scoping.',
        );
    }

    public function test_scope_locations_fmcs_on_allows_api_checkin_to_own_company_location(): void
    {
        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();
        $this->settings->disableFloaterMode();

        $company = Company::factory()->create();
        $actor = $company->users()->save(User::factory()->checkinAssets()->make());

        $initial = Location::factory()->make();
        $initial->company_id = $company->id;
        $initial->setValidating(false);
        $initial->save();

        $destination = Location::factory()->make();
        $destination->company_id = $company->id;
        $destination->setValidating(false);
        $destination->save();

        $target = $company->users()->save(User::factory()->make());
        $asset = Asset::factory()
            ->for($company)
            ->assignedToUser($target)
            ->create([
                'location_id' => $initial->id,
                'rtd_location_id' => $initial->id,
            ]);

        $this->actingAsForApi($actor)
            ->postJson(route('api.asset.checkin', $asset->id), [
                'location_id' => $destination->id,
            ])
            ->assertStatusMessageIs('success');

        $this->assertSame($destination->id, (int) $asset->fresh()->location_id);
    }
}
