@props([
    'request' => null,
    'requestable' => null,
])

{{-- Rendered on the four single-target checkout screens (asset /
     accessory / consumable / component / license) when the admin
     arrived from a /requests row (?request_id=N). Shows the current
     request for context. When there are additional pending
     requesters for the SAME requestable, appends a "bulk fulfill N
     open requests" link (same shape as the info-panel widget) that
     jumps to the bulk-fulfill screen where those siblings can be
     processed in one pass - the single-target screen only lets
     admin fulfill ONE request at a time, so listing the others
     inline was dead information.

     Renders nothing when $request is null --}}
@if (! empty($request))
    <x-box header="{{ trans('admin/hardware/general.requested') }}">
        <x-page-data>
            <x-data-row :label="trans('admin/hardware/table.requesting_user')">
                <a href="{{ route('users.show', $request->user->id) }}">{{ $request->user->display_name }}</a>
            </x-data-row>

            <x-data-row :label="trans('admin/hardware/table.requested_date')" icon_type="calendar">
                {{ $request->created_at->format($snipeSettings->date_display_format.' '.$snipeSettings->time_display_format) }}
                <span class="text-muted">{{ $request->created_at->diffForHumans(['parts' => 2]) }}</span>
            </x-data-row>

            <x-data-row :label="trans('admin/hardware/general.requested')">
                {{ (int) $request->quantity }}
            </x-data-row>

            @if ($request->start_date)
                <x-data-row :label="trans('general.start_date')" icon_type="start_date">
                    {{ $request->start_date->format($snipeSettings->date_display_format) }}
                </x-data-row>
            @endif

            @if ($request->end_date)
                <x-data-row :label="trans('general.end_date')" icon_type="end_date">
                    {{ $request->end_date->format($snipeSettings->date_display_format) }}
                </x-data-row>
            @endif

            @if ($request->notes)
                <x-data-row :label="trans('general.notes')">
                    {{ $request->notes }}
                </x-data-row>
            @endif

            {{-- "Other requesters + bulk-fulfill" link. Requestable::
                 bulkFulfillmentLink() gates on: (a) type is bulk-
                 eligible, (b) caller can checkout, (c) >=2 open
                 requests total, (d) stock available. Returns null
                 when any gate fails so the row is skipped. --}}
            @if ($requestable && method_exists($requestable, 'bulkFulfillmentLink') && $bulkFulfillmentLink = $requestable->bulkFulfillmentLink())
                <x-data-row :label="trans('admin/hardware/table.pending_requesters')" icon_type="fulfill_multiple">
                    <a href="{{ $bulkFulfillmentLink['url'] }}">
                        {{ trans_choice('admin/hardware/general.open_requests_count', $bulkFulfillmentLink['count'], ['count' => $bulkFulfillmentLink['count']]) }}
                    </a>
                </x-data-row>
            @endif
        </x-page-data>
    </x-box>
@endif
