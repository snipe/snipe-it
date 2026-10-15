<?php

namespace Tests\Feature\CalendarEvents;

use App\Http\Transformers\CalendarEventsTransformer;
use App\Models\Asset;
use App\Models\CalendarEvent;
use Tests\TestCase;

/**
 * Coverage for Asset::calendarEventDefinitions() specifically. The
 * shared HasCalendarEvents behavior (observer wiring, soft-delete
 * cascade, reconcile) is covered by CalendarEventsSyncTest against
 * Maintenance. This file pins the Asset-side entries and the
 * per-entry all_day semantics.
 *
 * Notable: last_checkout publishes as a NON all-day event because
 * checkouts happen at a specific moment in time. Every other Asset
 * event type is a date-only obligation (audit_due, expected_checkin,
 * eol, warranty_expiration) and stays all-day.
 */
class AssetEventDefinitionsTest extends TestCase
{
    public function test_setting_last_checkout_publishes_asset_checkout_calendar_event(): void
    {
        $checkoutAt = now()->setTime(14, 30, 0);
        $asset = Asset::factory()->create([
            'last_checkout' => $checkoutAt,
        ]);

        $event = CalendarEvent::where('source_type', Asset::class)
            ->where('source_id', $asset->id)
            ->where('source_field', 'last_checkout')
            ->first();

        $this->assertNotNull($event);
        $this->assertSame('asset.checkout', $event->event_type);
        $this->assertTrue($event->start->equalTo($checkoutAt));
    }

    public function test_asset_checkout_event_renders_with_time_of_day_not_all_day(): void
    {
        // The transformer reads all_day directly from
        // calendarEventDefinitions() at render time. Since checkouts
        // happen at a specific moment, the event should surface with
        // an ISO 8601 timestamp (time-of-day) rather than a date-only
        // string. Every other Asset event stays all-day.
        $checkoutAt = now()->setTime(9, 15, 0);
        $asset = Asset::factory()->create([
            'last_checkout' => $checkoutAt,
        ]);

        $row = CalendarEvent::where('source_type', Asset::class)
            ->where('source_id', $asset->id)
            ->where('source_field', 'last_checkout')
            ->first();

        $transformed = (new CalendarEventsTransformer)->transformCalendarEvents(
            [$row],
            [Asset::class => Asset::query()->whereKey($asset->id)->get()->keyBy('id')],
        );

        $this->assertCount(1, $transformed);
        $this->assertFalse(
            $transformed[0]['allDay'],
            'asset.checkout should render as a specific-time event, not all-day.'
        );
        $this->assertStringContainsString(
            'T',
            (string) $transformed[0]['start'],
            'A non-all-day event should serialize its start as an ISO 8601 timestamp with a time component.'
        );
    }

    public function test_setting_expected_checkin_still_publishes_all_day_calendar_event(): void
    {
        // Positive-side regression guard for the four all-day Asset
        // event types. If a future edit accidentally flips one of
        // these to non-all-day (or drops it entirely), the calendar
        // will change shape and this test catches it.
        $asset = Asset::factory()->create([
            'expected_checkin' => now()->addDays(7),
        ]);

        $row = CalendarEvent::where('source_type', Asset::class)
            ->where('source_id', $asset->id)
            ->where('source_field', 'expected_checkin')
            ->first();

        $this->assertNotNull($row);
        $this->assertSame('asset.expected_checkin', $row->event_type);

        $transformed = (new CalendarEventsTransformer)->transformCalendarEvents(
            [$row],
            [Asset::class => Asset::query()->whereKey($asset->id)->get()->keyBy('id')],
        );

        $this->assertTrue(
            $transformed[0]['allDay'],
            'expected_checkin should render as an all-day event because it represents a date-only obligation.'
        );
    }

    public function test_setting_next_audit_date_still_publishes_all_day_calendar_event(): void
    {
        $asset = Asset::factory()->create([
            'next_audit_date' => now()->addDays(30),
        ]);

        $row = CalendarEvent::where('source_type', Asset::class)
            ->where('source_id', $asset->id)
            ->where('source_field', 'next_audit_date')
            ->first();

        $this->assertNotNull($row);
        $this->assertSame('asset.audit_due', $row->event_type);

        $transformed = (new CalendarEventsTransformer)->transformCalendarEvents(
            [$row],
            [Asset::class => Asset::query()->whereKey($asset->id)->get()->keyBy('id')],
        );

        $this->assertTrue($transformed[0]['allDay']);
    }
}
