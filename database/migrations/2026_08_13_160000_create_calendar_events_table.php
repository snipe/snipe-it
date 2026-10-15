<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Polymorphic index of "when did what happen" across every source
 * model that opts in via HasCalendarEvents. The table stores only
 * the dates + a pointer back to the source row + a categorization
 * key for filter buttons on the calendar UI. Everything else (name,
 * url, color, badges) is resolved live from the source model at read
 * time via its presenter so this table stays free of drift-prone
 * denormalized fields.
 *
 * Sources register their date columns via the trait's
 * calendarEventDefinitions() method. The observer keeps rows in
 * sync on source save / delete / restore, and the
 * snipeit:reconcile-calendar-events command sweeps date drift plus
 * heals any orphans on demand.
 *
 * Composite unique on (source_type, source_id, source_field) is what
 * the observer upserts against - a single source can contribute
 * multiple rows (e.g. Maintenance publishes both start_date and
 * expected_completion_date events), one per declared field.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->id();

            $table->string('source_type');
            $table->unsignedBigInteger('source_id');
            $table->string('source_field');

            $table->string('event_type');

            $table->dateTime('start');
            $table->dateTime('end')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Upsert / delete lookup used by the observer on every
            // source save. Unique because a source can only publish
            // one event per field.
            $table->unique(
                ['source_type', 'source_id', 'source_field'],
                'calendar_events_source_unique'
            );

            // Read path filter: WHERE event_type IN (...) AND start
            // BETWEEN ? AND ?. Composite lets the planner satisfy both
            // predicates from the index.
            $table->index(['event_type', 'start'], 'calendar_events_type_start_index');

            // Read path FMCS filter: WHERE company_id IN (...) OR
            // company_id IS NULL (floater). Standalone index because
            // the composite above is ordered for the type+range query.
            $table->index('company_id', 'calendar_events_company_id_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calendar_events');
    }
};
