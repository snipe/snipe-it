<?php

namespace Tests\Feature\CalendarEvents;

use App\Models\User;
use Tests\TestCase;

/**
 * Coverage for the calendar page's controller-level gate. The web
 * controller's base check is "can the viewer view AT LEAST ONE of
 * the HasCalendarEvents source models" (Asset, License, User,
 * Maintenance) rather than a hardcoded view-Asset. That means a
 * license-only or user-only admin should be able to render the
 * calendar page shell and get their relevant events via the
 * companion API. These tests lock that behavior down.
 */
class CalendarEventsPageTest extends TestCase
{
    public function test_page_renders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('calendar.index'))
            ->assertOk();
    }

    public function test_requires_permission()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('calendar.index'))
            ->assertForbidden();
    }

    public function test_asset_only_viewer_can_render_the_page()
    {
        $this->actingAs(User::factory()->viewAssets()->create())
            ->get(route('calendar.index'))
            ->assertOk();
    }

    public function test_license_only_viewer_can_render_the_page()
    {
        // A user whose only calendar-relevant permission is view
        // Licenses should still land on the page shell. Per-row
        // filtering in the API endpoint drops the non-license events
        // downstream; the page-level gate should not lock them out.
        $this->actingAs(User::factory()->viewLicenses()->create())
            ->get(route('calendar.index'))
            ->assertOk();
    }

    public function test_user_only_viewer_can_render_the_page()
    {
        $this->actingAs(User::factory()->viewUsers()->create())
            ->get(route('calendar.index'))
            ->assertOk();
    }
}
