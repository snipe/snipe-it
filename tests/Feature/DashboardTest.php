<?php

namespace Tests\Feature;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\License;
use App\Models\User;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    public function test_users_with_no_visibility_are_redirected_to_own_assets(): void
    {
        // A regular user with no view grants on any HasCalendarEvents
        // adopter fails the canViewUsersAndCheckoutables gate and
        // still lands on their own /account/view-assets page, matching
        // the pre-widening behavior for people with no read access.
        $this->actingAs(User::factory()->create())
            ->get(route('home'))
            ->assertRedirect(route('view-assets'));
    }

    public function test_admin_sees_dashboard_with_top_boxes(): void
    {
        Asset::factory()->count(2)->create();

        $response = $this->actingAs(User::factory()->admin()->create())
            ->get(route('home'))
            ->assertOk()
            ->assertViewIs('dashboard');

        // Top-boxes row carries the counts array cells. The license
        // box uses number_format($counts['license']) so a rendered
        // dashboard for an admin includes the localized formatted
        // count. Non-admin coverage below asserts these are absent.
        $response->assertSee(trans('general.assets'), false);
        $response->assertSee(trans('general.licenses'), false);
    }

    public function test_non_admin_with_view_asset_sees_dashboard_without_top_boxes(): void
    {
        // A user with `assets.view` passes canViewUsersAndCheckoutables
        // (Asset is a HasCalendarEvents source) and gets the widget
        // section of the dashboard. The top-boxes row and the empty-
        // inventory shortcut both live behind the admin-only wrapper
        // and must not render.
        $viewer = User::factory()->viewAssets()->create();

        $response = $this->actingAs($viewer)
            ->get(route('home'))
            ->assertOk()
            ->assertViewIs('dashboard');

        // The top-box row wraps each cell in a "dashboard small-box"
        // div. Absence of that class in the rendered HTML proves the
        // admin-only region did not render.
        $response->assertDontSee('dashboard small-box', false);

        // The empty-inventory shortcut headline (only appears for
        // admins on empty installs) must also be absent for
        // non-admins regardless of inventory state.
        $response->assertDontSee(trans('general.dashboard_empty'), false);
    }

    public function test_counts_are_loaded_correctly_for_admins(): void
    {
        Asset::factory()->count(2)->create();
        Accessory::factory()->count(2)->create();
        License::factory()->count(2)->create();
        Consumable::factory()->count(2)->create();
        Component::factory()->count(2)->create();

        $this->actingAs(User::factory()->admin()->create())
            ->get(route('home'))
            ->assertViewIs('dashboard')
            ->assertViewHas('counts', function ($value) {
                $accessoryCount = Accessory::count();
                $assetCount = Asset::count();
                $componentCount = Component::count();
                $consumableCount = Consumable::count();
                $licenseCount = License::assetcount();
                $userCount = User::count();

                $this->assertEquals($value['accessory'], $accessoryCount, 'Accessory count incorrect.');
                $this->assertEquals($value['asset'], $assetCount, 'Asset count incorrect.');
                $this->assertEquals($value['license'], $licenseCount, 'License count incorrect.');
                $this->assertEquals($value['consumable'], $consumableCount, 'Consumable count incorrect.');
                $this->assertEquals($value['component'], $componentCount, 'Component count incorrect.');
                $this->assertEquals($value['user'], $userCount, 'User count incorrect.');
                $this->assertEquals(
                    $value['grand_total'],
                    $accessoryCount + $assetCount + $consumableCount + $licenseCount,
                    'Grand total count incorrect.'
                );

                return true;
            });
    }
}
