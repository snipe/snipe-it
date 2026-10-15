<?php

namespace Tests\Feature\Assets\Api;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AssignedAccessoriesTest extends TestCase
{
    public function test_requires_permission(): void
    {
        $this->actingAsForApi(User::factory()->create())
            ->getJson(route('api.assets.assigned_accessories', Asset::factory()->create()))
            ->assertForbidden();
    }

    public function test_adheres_to_company_scoping(): void
    {
        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $asset = Asset::factory()->for($companyA)->create();

        $user = User::factory()->forCompany($companyB)->viewAssets()->create();

        $this->actingAsForApi($user)
            ->getJson(route('api.assets.assigned_accessories', $asset))
            ->assertOk()
            ->assertStatusMessageIs('error')
            ->assertMessagesAre('Asset not found');
    }

    /**
     * Security regression pin, companion to
     * AssignedComponentsTest::test_does_not_leak_component_details_when_caller_lacks_components_view
     * for the parallel /assigned/accessories endpoint. Before the fix in
     * AssetsTransformer::transformCheckedoutAccessories, a caller with
     * assets.view but not accessories.view could read the accessory's
     * name / note / image straight off this response even though the
     * direct GET /api/v1/accessories/{id} correctly returned 403. Now
     * denied rows are omitted entirely and total is decremented so the
     * response neither reveals the accessory's id nor that it exists at
     * all.
     */
    public function test_does_not_leak_accessory_details_when_caller_lacks_accessories_view(): void
    {
        $asset = Asset::factory()->create();
        $accessory = Accessory::factory()->create(['name' => 'Hidden Bluetooth Adapter']);
        DB::table('accessories_checkout')->insert([
            'accessory_id' => $accessory->id,
            'assigned_to' => $asset->id,
            'assigned_type' => Asset::class,
            'note' => 'sensitive accessory note',
            'created_by' => User::factory()->superuser()->create()->id,
            'created_at' => now(),
        ]);

        // viewAssets only. No viewAccessories.
        $actor = User::factory()->viewAssets()->create();

        $this->actingAsForApi($actor)
            ->getJson(route('api.assets.assigned_accessories', $asset))
            ->assertOk()
            ->assertJsonPath('total', 0)
            ->assertJsonCount(0, 'rows');
    }

    /**
     * Positive-path sanity: a caller who DOES have accessories.view still
     * gets the full accessory details. Guards against the info-disclosure
     * guard accidentally stripping data from authorized callers.
     */
    public function test_returns_full_accessory_details_when_caller_has_accessories_view(): void
    {
        $asset = Asset::factory()->create();
        $accessory = Accessory::factory()->create(['name' => 'Visible Bluetooth Adapter']);
        DB::table('accessories_checkout')->insert([
            'accessory_id' => $accessory->id,
            'assigned_to' => $asset->id,
            'assigned_type' => Asset::class,
            'note' => 'accessory note',
            'created_by' => User::factory()->superuser()->create()->id,
            'created_at' => now(),
        ]);

        $actor = User::factory()->viewAssets()->viewAccessories()->create();

        $this->actingAsForApi($actor)
            ->getJson(route('api.assets.assigned_accessories', $asset))
            ->assertOk()
            ->assertJsonPath('total', 1)
            ->assertJsonPath('rows.0.accessory.id', $accessory->id)
            ->assertJsonPath('rows.0.accessory.name', 'Visible Bluetooth Adapter')
            ->assertJsonPath('rows.0.note', 'accessory note');
    }
}
