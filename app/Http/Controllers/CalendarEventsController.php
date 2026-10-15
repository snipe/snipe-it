<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

/**
 * Renders the unified calendar page. The heavy lifting (event
 * fetching, source hydration, per-row access checks) happens on the
 * companion API endpoint at /api/v1/calendar/events. This controller
 * just gates page access and returns the shell blade that the
 * FullCalendar JS bundle mounts into.
 */
class CalendarEventsController extends Controller
{
    public function index(): View
    {
        $this->authorize('canViewUsersAndCheckoutables');

        return view('calendar.index');
    }
}
