<?php

namespace Tests\Feature\CalendarEvents;

use App\Models\Asset;
use App\Models\Company;
use App\Models\Maintenance;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Regression tests for Wojciech Ciemski's CAND-07 report. Before
 * CalendarEvent gained CompanyableTrait + a denormalized company_id
 * column, the calendar API counted + ordered + limited rows BEFORE
 * applying FMCS filtering. That meant total leaked the count of
 * hidden events, and unauthorized rows at the start of the ordering
 * displaced authorized rows past the limit.
 */
class CalendarFmcsPreAuthScopingTest extends TestCase
{
    public function test_total_reflects_only_authorized_rows_under_fmcs(): void
    {
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();
        $assetA = Asset::factory()->for($companyA)->create();
        $assetB = Asset::factory()->for($companyB)->create();

        Maintenance::factory()->create([
            'asset_id' => $assetA->id,
            'start_date' => '2040-01-02 10:00:00',
            'expected_completion_date' => '2040-01-02 11:00:00',
        ]);
        Maintenance::factory()->create([
            'asset_id' => $assetB->id,
            'start_date' => '2040-01-01 10:00:00',
            'expected_completion_date' => '2040-01-01 11:00:00',
        ]);

        $actor = $companyA->users()->save(User::factory()->viewAssets()->editAssets()->make());

        $response = $this->actingAsForApi($actor)
            ->getJson(route('api.calendar.events', [
                'start' => '2040-01-01T00:00:00+00:00',
                'end' => '2040-01-03T00:00:00+00:00',
                'event_type' => ['maintenance.start'],
                'limit' => 500,
            ]))
            ->assertOk();

        $this->assertSame(1, $response->json('total'), 'Total must count only the Company A event');
        $this->assertCount(1, $response->json('events'));
    }

    public function test_limit_does_not_consume_authorized_rows_with_unauthorized_rows_under_fmcs(): void
    {
        // The failure mode in the original report: Company B's event
        // sorts earlier, consumes the one-row limit, gets filtered,
        // and the authorized Company A event never surfaces. After the
        // fix, the limit applies to the authorized set so the
        // Company A event comes back.
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();
        $assetA = Asset::factory()->for($companyA)->create();
        $assetB = Asset::factory()->for($companyB)->create();

        Maintenance::factory()->create([
            'asset_id' => $assetB->id,
            'start_date' => '2040-01-01 10:00:00',
            'expected_completion_date' => '2040-01-01 11:00:00',
        ]);
        $maintenanceA = Maintenance::factory()->create([
            'asset_id' => $assetA->id,
            'start_date' => '2040-01-02 10:00:00',
            'expected_completion_date' => '2040-01-02 11:00:00',
        ]);

        $actor = $companyA->users()->save(User::factory()->viewAssets()->editAssets()->make());

        $response = $this->actingAsForApi($actor)
            ->getJson(route('api.calendar.events', [
                'start' => '2040-01-01T00:00:00+00:00',
                'end' => '2040-01-03T00:00:00+00:00',
                'event_type' => ['maintenance.start'],
                'limit' => 1,
            ]))
            ->assertOk();

        $this->assertSame(1, $response->json('total'));
        $this->assertFalse($response->json('truncated'), 'Only one authorized event exists, so truncated must be false');

        $sourceIds = collect($response->json('events'))->pluck('extendedProps.source_id')->all();
        $this->assertContains($maintenanceA->id, $sourceIds);
    }

    public function test_asset_company_change_cascades_to_maintenance_calendar_events(): void
    {
        // When an admin moves an asset between companies, the child
        // maintenance's calendar_events row needs to pick up the new
        // company_id or FMCS filtering stays stale. Asset::booted()
        // registers an updated hook that cascades forceSyncCalendarEvents
        // to maintenances when company_id changes.
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();
        $asset = Asset::factory()->for($companyA)->create();
        $maintenance = Maintenance::factory()->create([
            'asset_id' => $asset->id,
            'start_date' => '2040-01-02 10:00:00',
            'expected_completion_date' => '2040-01-02 11:00:00',
        ]);

        $this->assertSame($companyA->id, (int) DB::table('calendar_events')
            ->where('source_type', Maintenance::class)
            ->where('source_id', $maintenance->id)
            ->value('company_id'));

        $asset->update(['company_id' => $companyB->id]);

        $this->assertSame($companyB->id, (int) DB::table('calendar_events')
            ->where('source_type', Maintenance::class)
            ->where('source_id', $maintenance->id)
            ->value('company_id'));
    }

    public function test_asset_company_change_updates_the_assets_own_calendar_event_row(): void
    {
        // Direct test of the trait-level implicit company_id trigger
        // added so sources with a company_id column auto-re-sync when
        // it changes, without each definition declaring it.
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();
        $asset = Asset::factory()->for($companyA)->create([
            'next_audit_date' => '2040-02-01',
        ]);

        $this->assertSame($companyA->id, (int) DB::table('calendar_events')
            ->where('source_type', Asset::class)
            ->where('source_id', $asset->id)
            ->where('event_type', 'asset.audit_due')
            ->value('company_id'));

        $asset->update(['company_id' => $companyB->id]);

        $this->assertSame($companyB->id, (int) DB::table('calendar_events')
            ->where('source_type', Asset::class)
            ->where('source_id', $asset->id)
            ->where('event_type', 'asset.audit_due')
            ->value('company_id'));
    }
}
