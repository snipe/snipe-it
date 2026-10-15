<?php

namespace Tests\Feature\Locations\Api;

use App\Models\Accessory;
use App\Models\AccessoryCheckout;
use App\Models\Company;
use App\Models\Location;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Regression test for cross-tenant AccessoryCheckout
 * pivot leak on GET /api/v1/locations/{location-id}/assigned/accessories.
 *
 * Before the fix, AccessoryCheckout had no company scope. The endpoint
 * queried pivots by assigned_to=location_id, applied CompanyableScope
 * only on the nested accessory relation at serialization time, and
 * leaked pivot id, note, timestamp, created_by, assigned_to, and total
 * for cross-company checkouts whose parent accessory was invisible.
 *
 * Fix is a global CompanyableChildScope on AccessoryCheckout that
 * joins against accessories and applies CompanyableScope on the parent.
 */
class AssignedAccessoriesFmcsLeakTest extends TestCase
{
    public function test_cross_company_accessory_checkout_at_shared_location_is_hidden_under_fmcs(): void
    {
        // scope_locations_fmcs = 0 (default) means locations are shared
        // across tenants, so Company B's accessory can be checked out at
        // a Company A location. Before the fix, the pivot id / note /
        // timestamp / created_by / assigned_to leaked to the Company A
        // actor on GET /api/v1/locations/{id}/assigned/accessories, even
        // though the nested accessory relation came back null because
        // the per-model CompanyableScope hid it.
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();
        $locationA = Location::factory()->create(['company_id' => $companyA->id]);

        $foreignAccessory = Accessory::factory()->create([
            'company_id' => $companyB->id,
            'name' => 'CAND18 Company B Accessory',
        ]);

        AccessoryCheckout::create([
            'accessory_id' => $foreignAccessory->id,
            'assigned_to' => $locationA->id,
            'assigned_type' => Location::class,
            'note' => 'CAND18-CROSS-TENANT-PIVOT-NOTE',
        ]);

        $actorA = $this->userInCompany($companyA);

        $response = $this->actingAsForApi($actorA)
            ->getJson(route('api.locations.assigned_accessories', ['location' => $locationA->id]))
            ->assertOk();

        $this->assertSame(0, $response->json('total'), 'Total must not count cross-company pivot rows.');
        $this->assertSame([], $response->json('rows'), 'Rows must not include cross-company pivot metadata.');
        $response->assertDontSee('CAND18-CROSS-TENANT-PIVOT-NOTE');
    }

    public function test_same_company_accessory_checkout_still_visible_under_fmcs(): void
    {
        // Control. The fix must not hide pivots the caller legitimately
        // sees.
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $locationA = Location::factory()->create(['company_id' => $companyA->id]);

        $ownAccessory = Accessory::factory()->create([
            'company_id' => $companyA->id,
            'name' => 'CAND18 Company A Accessory',
        ]);

        AccessoryCheckout::create([
            'accessory_id' => $ownAccessory->id,
            'assigned_to' => $locationA->id,
            'assigned_type' => Location::class,
            'note' => 'CAND18-OWN-TENANT-NOTE',
        ]);

        $actorA = $this->userInCompany($companyA);

        $response = $this->actingAsForApi($actorA)
            ->getJson(route('api.locations.assigned_accessories', ['location' => $locationA->id]))
            ->assertOk();

        $this->assertSame(1, $response->json('total'));
        $response->assertSee('CAND18-OWN-TENANT-NOTE');
    }

    public function test_fmcs_off_user_sees_cross_company_pivots_as_before(): void
    {
        // When FMCS is off, there is no tenant boundary to enforce.
        // Cross-company checkouts remain visible.
        $this->settings->disableMultipleFullCompanySupport();

        $companyB = Company::factory()->create();
        $location = Location::factory()->create();

        $foreignAccessory = Accessory::factory()->create([
            'company_id' => $companyB->id,
            'name' => 'CAND18 Company B Accessory',
        ]);

        AccessoryCheckout::create([
            'accessory_id' => $foreignAccessory->id,
            'assigned_to' => $location->id,
            'assigned_type' => Location::class,
            'note' => 'CAND18-FMCS-OFF-NOTE',
        ]);

        $actor = User::factory()->viewAccessories()->viewLocationHistory()->create();

        $response = $this->actingAsForApi($actor)
            ->getJson(route('api.locations.assigned_accessories', ['location' => $location->id]))
            ->assertOk();

        $this->assertSame(1, $response->json('total'));
        $response->assertSee('CAND18-FMCS-OFF-NOTE');
    }

    private function userInCompany(Company $company): User
    {
        $user = User::factory()->viewAccessories()->viewLocationHistory()->create();
        DB::table('company_user')->insert([
            'company_id' => $company->id,
            'user_id' => $user->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $user;
    }
}
