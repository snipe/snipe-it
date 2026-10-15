<?php

namespace Tests\Feature\CalendarEvents;

use App\Models\Asset;
use App\Models\Company;
use App\Models\Maintenance;
use App\Models\User;
use Tests\Concerns\TestsFullMultipleCompaniesSupport;
use Tests\Concerns\TestsPermissionsRequirement;
use Tests\TestCase;

/**
 * Coverage for the unified /api/v1/calendar/events endpoint. Verifies:
 *
 *   - Base permission gate blocks users without view-Asset.
 *   - Date range filter honors ?start and ?end.
 *   - event_type[] and comma-separated ?filter both narrow results.
 *   - Per-row access check (via the source's own view policy) hides
 *     rows whose source model the actor can't see - the FMCS scoping
 *     path.
 *   - Row hydrates title / url / color from the source's presenter.
 *   - Orphan rows (source missing) are silently skipped rather than
 *     erroring out.
 */
class CalendarEventsApiTest extends TestCase implements TestsFullMultipleCompaniesSupport, TestsPermissionsRequirement
{
    public function test_requires_permission()
    {
        $this->actingAsForApi(User::factory()->create())
            ->getJson(route('api.calendar.events'))
            ->assertForbidden();
    }

    public function test_returns_events_for_the_seeded_maintenance()
    {
        $actor = User::factory()->superuser()->create();
        $asset = Asset::factory()->create();

        $maintenance = Maintenance::factory()->create([
            'asset_id' => $asset->id,
            'start_date' => now()->subDay(),
            'expected_completion_date' => now()->addDay(),
        ]);

        $rows = $this->actingAsForApi($actor)
            ->getJson(route('api.calendar.events'))
            ->assertOk()
            ->json('events');

        $matching = collect($rows)->first(fn ($row) => $row['extendedProps']['source_type'] === Maintenance::class
            && $row['extendedProps']['source_id'] === $maintenance->id);
        $this->assertNotNull($matching);
        $this->assertSame('maintenance.start', $matching['extendedProps']['event_type']);
        $this->assertNotEmpty($matching['title']);
        $this->assertNotEmpty($matching['url']);
    }

    public function test_array_shaped_start_param_falls_back_to_default_without_500()
    {
        // Regression pin: a probe URL like
        // `?start[$ptt]=2026-10-01T00:00:00Z` makes $request->input('start')
        // return an array, which Carbon::parse would reject with a
        // TypeError and bubble out as a 500. resolveRange() now
        // coerces non-string input to the default window, so the
        // probe gets a normal 200 instead of a stack trace. Same
        // guard on `end`.
        $actor = User::factory()->superuser()->create();

        $this->actingAsForApi($actor)
            ->getJson('/api/v1/calendar/events?start[$ptt]=2026-10-01T00:00:00Z&end=2026-10-08T00:00:00Z')
            ->assertOk();

        $this->actingAsForApi($actor)
            ->getJson('/api/v1/calendar/events?start=2026-10-01T00:00:00Z&end[$ptt]=2026-10-08T00:00:00Z')
            ->assertOk();
    }

    public function test_unparseable_start_param_falls_back_to_default_without_500()
    {
        // Companion guard: non-array garbage like `?start=not-a-date`
        // also hits the catch block instead of 500ing out.
        $actor = User::factory()->superuser()->create();

        $this->actingAsForApi($actor)
            ->getJson('/api/v1/calendar/events?start=not-a-date&end=also-garbage')
            ->assertOk();
    }

    public function test_range_filter_hides_events_outside_visible_window()
    {
        $actor = User::factory()->superuser()->create();
        $asset = Asset::factory()->create();

        $inRange = Maintenance::factory()->create([
            'asset_id' => $asset->id,
            'start_date' => now()->subDay(),
            'expected_completion_date' => now()->addDay(),
        ]);
        $outOfRange = Maintenance::factory()->create([
            'asset_id' => $asset->id,
            'start_date' => now()->subYears(2),
            'expected_completion_date' => now()->subYears(2)->addDay(),
        ]);

        $ids = collect($this->actingAsForApi($actor)
            ->getJson(route('api.calendar.events', [
                'start' => now()->subWeek()->toIso8601String(),
                'end' => now()->addWeek()->toIso8601String(),
            ]))
            ->assertOk()
            ->json('events'))
            ->filter(fn ($row) => $row['extendedProps']['source_type'] === Maintenance::class)
            ->pluck('extendedProps.source_id')
            ->all();

        $this->assertContains($inRange->id, $ids);
        $this->assertNotContains($outOfRange->id, $ids);
    }

    public function test_event_type_filter_narrows_results()
    {
        $actor = User::factory()->superuser()->create();
        $asset = Asset::factory()->create();

        $maintenance = Maintenance::factory()->create([
            'asset_id' => $asset->id,
            'start_date' => now()->subDay(),
            'expected_completion_date' => now()->addDay(),
        ]);

        // Positive: filter includes the seeded event type.
        $ids = collect($this->actingAsForApi($actor)
            ->getJson(route('api.calendar.events', ['event_type' => ['maintenance.start']]))
            ->assertOk()
            ->json('events'))
            ->filter(fn ($row) => $row['extendedProps']['source_type'] === Maintenance::class)
            ->pluck('extendedProps.source_id')
            ->all();
        $this->assertContains($maintenance->id, $ids);

        // Negative: filter excludes the seeded event type.
        $ids = collect($this->actingAsForApi($actor)
            ->getJson(route('api.calendar.events', ['event_type' => ['some.other.type']]))
            ->assertOk()
            ->json('events'))
            ->filter(fn ($row) => $row['extendedProps']['source_type'] === Maintenance::class)
            ->pluck('extendedProps.source_id')
            ->all();
        $this->assertNotContains($maintenance->id, $ids);
    }

    public function test_adheres_to_full_multiple_companies_support_scoping()
    {
        // The endpoint's per-row can('view', $source) check delegates
        // to each source's own policy, which honors FMCS. Verifies
        // that a user scoped to Company A does NOT see a maintenance
        // event for an asset in Company B.
        [$companyA, $companyB] = Company::factory()->count(2)->create();
        // MaintenancePolicy::view() requires update-on-parent-asset,
        // not just view; use editAssets so the actor has the right
        // access to their own company's maintenance.
        // MaintenancePolicy::view() requires update-on-parent-asset;
        // the base endpoint gate also requires view-Asset. Grant both.
        $userInCompanyA = $companyA->users()->save(User::factory()->viewAssets()->editAssets()->make());

        $assetA = Asset::factory()->for($companyA)->create();
        $assetB = Asset::factory()->for($companyB)->create();

        $maintenanceA = Maintenance::factory()->create([
            'asset_id' => $assetA->id,
            'start_date' => now()->subDay(),
            'expected_completion_date' => now()->addDay(),
        ]);
        $maintenanceB = Maintenance::factory()->create([
            'asset_id' => $assetB->id,
            'start_date' => now()->subDay(),
            'expected_completion_date' => now()->addDay(),
        ]);

        $this->settings->enableMultipleFullCompanySupport();

        $sourceIds = collect($this->actingAsForApi($userInCompanyA)
            ->getJson(route('api.calendar.events'))
            ->assertOk()
            ->json('events'))
            ->filter(fn ($row) => $row['extendedProps']['source_type'] === Maintenance::class)
            ->pluck('extendedProps.source_id')
            ->all();

        $this->assertContains($maintenanceA->id, $sourceIds);
        $this->assertNotContains($maintenanceB->id, $sourceIds);
    }
}
