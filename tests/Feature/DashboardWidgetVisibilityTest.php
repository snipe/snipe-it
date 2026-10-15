<?php

namespace Tests\Feature;

use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Company;
use App\Models\Location;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Access / auth tests for the non-admin dashboard widget endpoints.
 * The dashboard is reachable by any user who passes
 * canViewUsersAndCheckoutables (can view at least one
 * HasCalendarEvents source). Each purpose-built api.dashboard.*
 * endpoint has to accept those callers too, or the widget renders
 * an ugly "Could not load results, 403". The general-purpose
 * per-domain index endpoints must stay 403'd against scoped
 * viewers so they can't sidestep the narrow widget surface.
 *
 * Payload-shape / filter tests live in
 * DashboardWidgetPayloadShapeTest so each file stays under PHPMD's
 * per-class method threshold.
 */
class DashboardWidgetVisibilityTest extends TestCase
{
    public function test_scoped_viewer_can_reach_companies_widget(): void
    {
        Company::factory()->count(2)->create();

        Passport::actingAs(User::factory()->viewAccessories()->create());

        $this->getJson(route('api.dashboard.companies'))->assertOk();
    }

    public function test_scoped_viewer_can_reach_locations_widget(): void
    {
        Location::factory()->count(2)->create();

        Passport::actingAs(User::factory()->viewAccessories()->create());

        $this->getJson(route('api.dashboard.locations'))->assertOk();
    }

    public function test_scoped_viewer_can_reach_categories_widget(): void
    {
        Passport::actingAs(User::factory()->viewAccessories()->create());

        $this->getJson(route('api.dashboard.categories'))->assertOk();
    }

    public function test_scoped_viewer_still_forbidden_on_general_index_endpoints(): void
    {
        // The dashboard now hits purpose-built api.dashboard.* twins.
        // A scoped viewer must still get 403 on the general-purpose
        // per-domain indexes, whose query surface exposes far more
        // than the widget renders. Regression guard for the widen
        // that used to live on these endpoints.
        Passport::actingAs(User::factory()->viewAccessories()->create());

        $this->getJson(route('api.companies.index'))->assertForbidden();
        $this->getJson(route('api.locations.index'))->assertForbidden();
        $this->getJson(route('api.categories.index'))->assertForbidden();
        $this->getJson(route('api.activity.index'))->assertForbidden();
    }

    public function test_permissionless_user_still_forbidden_on_each_widget_endpoint(): void
    {
        // A base user without any view grants still fails
        // canViewUsersAndCheckoutables and gets 403 on each widget
        // endpoint. Keeps the coarse gate meaningful.
        Passport::actingAs(User::factory()->create());

        $this->getJson(route('api.dashboard.companies'))->assertForbidden();
        $this->getJson(route('api.dashboard.locations'))->assertForbidden();
        $this->getJson(route('api.dashboard.categories'))->assertForbidden();
        $this->getJson(route('api.dashboard.activity'))->assertForbidden();
    }

    public function test_full_activity_view_still_sees_every_row(): void
    {
        // Superuser (implicit activity.view via hasAccess('admin'))
        // must still see the full unfiltered feed. Regression guard
        // for the widened gate.
        $asset = Asset::factory()->create();
        $accessory = Accessory::factory()->create();

        Actionlog::factory()->create([
            'item_type' => Asset::class,
            'item_id' => $asset->id,
            'action_type' => 'checkout',
            'note' => 'FULL_ASSET_ROW',
        ]);
        Actionlog::factory()->create([
            'item_type' => Accessory::class,
            'item_id' => $accessory->id,
            'action_type' => 'checkout',
            'note' => 'FULL_ACCESSORY_ROW',
        ]);

        Passport::actingAs(User::factory()->superuser()->create());

        $response = $this->getJson(route('api.activity.index'))->assertOk();
        $body = $response->getContent();

        $this->assertStringContainsString('FULL_ASSET_ROW', $body);
        $this->assertStringContainsString('FULL_ACCESSORY_ROW', $body);
    }
}
